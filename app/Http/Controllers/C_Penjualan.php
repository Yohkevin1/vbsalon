<?php

namespace App\Http\Controllers;

use App\Models\Detail_Jasa;
use App\Models\Detail_Produk;
use App\Models\Jasa;
use App\Models\Pegawai;
use App\Models\Penjualan;
use App\Models\Produk;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use TCPDF;

class C_Penjualan extends Controller
{
    public function index()
    {
        session()->forget('cart');
        $trs = Penjualan::whereBetween('created_at', [date('Y-m-01'), date('Y-m-t') . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
        $pegawai = Pegawai::all();
        return view('penjualan.indexTransaksi', compact('trs', 'pegawai'));
    }

    public function storeTransaksi()
    {
        session()->forget('cart');
        $jasa = Jasa::all();
        $produk = Produk::where('jumlah', '>', 0)->where('status', '!=', 'return')->get();
        $pegawai = Pegawai::all();
        $cart = session()->get('cart', []);

        return view('penjualan.storeTransaksi', compact('jasa', 'produk', 'cart', 'pegawai'));
    }

    public function addToCart(Request $request)
    {
        $id = $request->input('id');
        $produk = Produk::where('kode_produk', $id)->first();
        $jasa = Jasa::where('id_jasa', $id)->first();
        $cart = session()->get('cart', []);
        if (!empty($produk)) {
            $type = "produk";
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'foto' => 'images/produk/' . $produk->foto,
                    'name' => $produk->merek,
                    'price' => $produk->harga,
                    'type' => $type,
                    'quantity' => 1,
                    'subtotal' => $produk->harga, // Harga awal sebagai subtotal
                ];
            }
        } else {
            $type = "jasa";
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    'foto' => 'images/jasa/' . $jasa->foto,
                    'name' => $jasa->nama_jasa,
                    'price' => $jasa->harga,
                    'type' => $type,
                    'quantity' => 1,
                    'subtotal' => $jasa->harga, // Harga awal sebagai subtotal
                ];
            }
        }

        // Menghitung subtotal untuk setiap item dalam keranjang
        foreach ($cart as $index => $item) {
            $cart[$index]['subtotal'] = $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);

        return $this->loadCart();
    }

    public function getTotal()
    {
        $cart = session()->get('cart', []);
        $totalBayar = 0;
        foreach ($cart as $index => $item) {
            $totalBayar += $item['subtotal'];
        }
        echo 'Rp ' . number_format($totalBayar, 2, ',', '.');
    }

    public function loadCart()
    {
        $cart = session()->get('cart', []);
        $output = '';
        $no = 1;
        if (empty($cart)) {
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        } else {
            $no = 1; // Inisialisasi nomor urutan
            foreach ($cart as $index => $item) {
                $output .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td><img src="' . asset($item['foto']) . '" alt="" width="100"></td>
                    <td style="width: 20%;">' . $item['name'] . '</td>
                    <td style="width: 15%;">' . $item['quantity'] . '</td>
                    <td style="width: 17%;">Rp ' . number_format($item['price'], 0, ',', '.') . '</td>
                    <td style="width: 17%;">Rp ' . number_format($item['subtotal'], 0, ',', '.') . '</td>
                    <td style="width: 17%;"><button id="' . $index . '" qty="' . $item['quantity'] . '" class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa fa-edit"></i></button>
                    <button type="button" id="' . $index . '" class="hapus_cart btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></button></td>
                </tr>';
            }
        }
        echo $output;
    }

    public function updateCart(Request $request)
    {
        $rowid = $request->input('id');
        $qty = $request->input('qty');

        $cart = session()->get('cart', []);

        if (!empty($cart) && isset($cart[$rowid])) {
            if ($qty > 0) {
                $cart[$rowid]['quantity'] = $qty;
                $cart[$rowid]['subtotal'] = $cart[$rowid]['price'] * $qty;
            } else {
                unset($cart[$rowid]);
            }
            session()->put('cart', $cart);
        }

        return $this->loadCart();
    }

    public function removeCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
    }

    public function pembayaran(Request $request)
    {
        $cart = session()->get('cart', []);
        $pegawai = $request->input('no_pegawai');
        $telp = $request->input('telp_pel');
        $nominal = $request->input('nominal');

        $response = []; // Inisialisasi array response

        if (empty($cart)) {
            $response = [
                'status' => false,
                'msg' => 'Keranjang Masih Kosong',
            ];
        } elseif (empty($pegawai)) {
            $response = [
                'status' => false,
                'msg' => 'Pegawai Belum Diinput',
            ];
        } elseif ($telp == null && !preg_match('/^(?:\+62|0[8-9])[0-9]{8,15}$/', $telp) || !is_numeric($telp)) {
            $response = [
                'status' => false,
                'msg' => 'Format No. Handphone tidak valid',
            ];
        } else {
            $statusStock = true;
            foreach ($cart as $index => $item) {
                if ($item['type'] == 'produk') {
                    $produk = Produk::where(['kode_produk' => $index])->first();
                    if ($produk['jumlah'] < $item['quantity']) {
                        $statusStock = false;
                        break;
                    }
                }
            }
            if (!$statusStock) {
                $response = [
                    'status' => false,
                    'msg' => 'Stok Produk Tidak Mencukupi',
                ];
            } else {
                $totalHarga = 0;
                foreach ($cart as $index => $item) {
                    $totalHarga += $item['subtotal'];
                }

                if (!is_numeric($nominal)) {
                    $response = [
                        'status' => false,
                        'msg' => 'Nominal tidak valid',
                    ];
                } elseif ($nominal < $totalHarga || empty($nominal)) {
                    $response = [
                        'status' => false,
                        'msg' => 'Nominal Pembayaran Kurang',
                    ];
                } else {
                    $id = $this->generateID();
                    Penjualan::insert([
                        'no_penjualan' => $id,
                        'telp_pelanggan' => $telp ?? null,
                        'total_harga' => $totalHarga,
                        'no_pegawai' => $pegawai,
                        'bayar' => $nominal,
                    ]);
                    foreach ($cart as $index => $item) {
                        if ($item['type'] == 'produk') {
                            Detail_Produk::insert([
                                'no_penjualan' => $id,
                                'kode_produk' => $index,
                                'jumlah'  => $item['quantity'],
                                'subtotal'   => $item['subtotal'],
                            ]);

                            $produk = Produk::where('kode_produk', $index)->first();
                            Produk::where('kode_produk', $index)->update([
                                'jumlah' => $produk->jumlah - $item['quantity']
                            ]);
                            $this->ubahStatus($index);
                        } else {
                            Detail_Jasa::insert([
                                'no_penjualan' => $id,
                                'id_jasa' => $index,
                                'jumlah'  => $item['quantity'],
                                'subtotal'   => $item['subtotal'],
                            ]);
                        }
                    }
                    session()->forget('cart');
                    $kembalian = $nominal - $totalHarga;

                    // if (!empty($telp)) {
                    //     $this->Nota($id);
                    //     $this->sendImageMessage($telp, $id);
                    // }

                    $response = [
                        'status' => true,
                        'msg' => 'Pembayaran berhasil',
                        'data' => [
                            'kembalian' => 'Rp ' . number_format($kembalian, 2, ',', '.')
                        ],
                    ];
                }
            }
        }
        echo json_encode($response);
    }

    public function generateID()
    {
        $lastPenjualan = Penjualan::withTrashed()->orderBy('created_at', 'DESC')->first();
        $currentDate = now();
        $formattedDate = $currentDate->format('dmy');
        $no = 1;

        // Jika ada data ID Produk terakhir
        if ($lastPenjualan) {
            // Menguraikan ID Produk terakhir dan mengambil bulannya
            $bulanTerakhir = substr($lastPenjualan->no_penjualan, 5, 2); // Ambil bulan dari ID terakhir

            // Jika bulan terakhir sama dengan bulan sekarang
            if ($bulanTerakhir == $currentDate->format('m')) {
                // Increment nomor dari ID Pegawai terakhir
                $no = intval(substr($lastPenjualan->no_penjualan, -5)) + 1;
            }
        }

        $noPenjualan = "PJL" . $formattedDate . str_pad($no, 5, '0', STR_PAD_LEFT);
        return $noPenjualan;
    }

    public function editPagePJL($id)
    {
        $id = decrypt($id);
        $cart = session()->get('cart', []);
        $jasa = Jasa::all();
        $produk = Produk::all();
        $pegawai = Pegawai::all();
        $pjl = Penjualan::where('no_penjualan', $id)->first();
        $DP = Detail_Produk::where('no_penjualan', $pjl->no_penjualan)->get();
        $DJ = Detail_Jasa::where('no_penjualan', $pjl->no_penjualan)->get();

        if (!empty($DP)) {
            $type = "produk";
            foreach ($DP as $item) {
                $cartItem = [
                    'foto' => 'images/produk/' . $item->produk->foto,
                    'name' => $item->produk->merek,
                    'price' => $item->produk->harga,
                    'type' => $type,
                    'quantity' => $item->jumlah,
                    'subtotal' => $item->produk->harga,
                ];
                $cart[$item->kode_produk] = $cartItem;
            }
        }
        if (!empty($DJ)) {
            $type = "jasa";
            foreach ($DJ as $item) {
                $cartItem = [
                    'foto' => 'images/jasa/' . $item->jasa->foto,
                    'name' => $item->jasa->nama_jasa,
                    'price' => $item->jasa->harga,
                    'type' => $type,
                    'quantity' => $item->jumlah,
                    'subtotal' => $item->jasa->harga,
                ];
                $cart[$item->id_jasa] = $cartItem;
            }
        }

        foreach ($cart as $index => $item) {
            $cart[$index]['subtotal'] = $item['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);

        return view('penjualan.storeEditTransaksi', compact('pjl', 'cart', 'produk', 'jasa', 'pegawai'));
    }

    public function updatePembayaran(Request $request)
    {
        $id = $request->input('no_penjualan');

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            $response = [
                'status' => false,
                'msg' => 'Keranjang Masih Kosong',
            ];
        } else {
            $pegawai = $request->input('no_pegawai');
            if (empty($pegawai)) {
                $response = [
                    'status' => false,
                    'msg' => 'Pegawai Belum Diinput',
                ];
            } else {
                $telp = $request->input('telp_pel');
                if ($telp == null && !preg_match('/^(?:\+62|0[8-9])[0-9]{8,15}$/', $telp) || !is_numeric($telp)) {
                    $response = [
                        'status' => false,
                        'msg' => 'Format No. Handphone tidak valid',
                    ];
                } else {
                    $statusStock = true;
                    foreach ($cart as $index => $item) {
                        if ($item['type'] == 'produk') {
                            $produk = Produk::where(['kode_produk' => $index])->first();
                            if ($produk['jumlah'] < $item['quantity']) {
                                $statusStock = false;
                                break;
                            }
                        }
                    }
                    if (!$statusStock) {
                        // Jika stok buku tidak mencukupi
                        $response = [
                            'status' => false,
                            'msg' => 'Stok Produk Tidak Mencukupi',
                        ];
                    } else {
                        $totalHarga = 0;
                        foreach ($cart as $index => $item) {
                            $totalHarga += $item['subtotal'];
                        }
                        $nominal = (int)$request->input('nominal');
                        if (!is_numeric($nominal)) {
                            $response = [
                                'status' => false,
                                'msg' => 'Nominal tidak valid',
                            ];
                        } elseif ($nominal < $totalHarga || empty($nominal)) {
                            $response = [
                                'status' => false,
                                'msg' => 'Nominal Pembayaran Kurang',

                            ];
                        } else {
                            $this->restoreItem($id);
                            foreach ($cart as $index => $item) {
                                if ($item['type'] == 'produk') {
                                    Detail_Produk::insert([
                                        'no_penjualan' => $id,
                                        'kode_produk' => $index,
                                        'jumlah'  => $item['quantity'],
                                        'subtotal'   => $item['subtotal'],
                                    ]);

                                    $produk = Produk::where('kode_produk', $index)->first();
                                    Produk::where('kode_produk', $index)->update([
                                        'jumlah' => $produk->jumlah - $item['quantity']
                                    ]);
                                    $this->ubahStatus($index);
                                } else {
                                    Detail_Jasa::insert([
                                        'no_penjualan' => $id,
                                        'id_jasa' => $index,
                                        'jumlah'  => $item['quantity'],
                                        'subtotal'   => $item['subtotal'],
                                    ]);
                                }
                            }
                            Penjualan::where('no_penjualan', $id)->update([
                                'no_pegawai' => $pegawai,
                                'bayar' => $nominal,
                                'total_harga' => $totalHarga,
                            ]);
                            session()->forget('cart');
                            $kembalian = $nominal - $totalHarga;

                            $response = [
                                'status' => true,
                                'msg' => 'Pembayaran berhasil',
                                'data' => [
                                    'kembalian' => 'Rp ' . number_format($kembalian, 2, ',', '.')
                                ],
                            ];
                        }
                    }
                }
            }
        }
        echo json_encode($response);
    }

    public function restoreItem($id)
    {
        $DP = Detail_Produk::where('no_penjualan', $id)->get();

        if (!empty($DP)) {
            foreach ($DP as $item) {
                $produk = Produk::where('kode_produk', $item->kode_produk)->first();
                Produk::where('kode_produk', $item->kode_produk)->update([
                    'jumlah' => $produk->jumlah + $item->jumlah,
                    'status' => 'ready',
                ]);
            }
        }

        Detail_Produk::where('no_penjualan', $id)->delete();
        Detail_Jasa::where('no_penjualan', $id)->delete();
    }

    public function ubahStatus($id)
    {
        $produk = Produk::where('kode_produk', $id)->first();

        if ($produk->jumlah == 0) {
            Produk::where('kode_produk', $id)->update([
                'status' => "habis",
            ]);
        }
    }

    public function detailPJL($id)
    {
        $cart = session()->get('cart', []);
        $id = decrypt($id);
        $pjl = Penjualan::where('no_penjualan', $id)->first();
        $DP = Detail_Produk::where('no_penjualan', $pjl->no_penjualan)->get();
        $DJ = Detail_Jasa::where('no_penjualan', $pjl->no_penjualan)->get();
        $type = '';

        $items = $DP->map(function ($item) use (&$type) {
            $type = "produk";
            return [
                'foto' => 'images/produk/' . $item->produk->foto,
                'name' => $item->produk->merek,
                'price' => $item->produk->harga,
                'type' => $type,
                'quantity' => $item->jumlah,
                'subtotal' => $item->produk->harga,
            ];
        })->concat($DJ->map(function ($item) use (&$type) {
            $type = "jasa";
            return [
                'foto' => 'images/jasa/' . $item->jasa->foto,
                'name' => $item->jasa->nama_jasa,
                'price' => $item->jasa->harga,
                'type' => $type,
                'quantity' => $item->jumlah,
                'subtotal' => $item->jasa->harga,
            ];
        }));

        $items->transform(function ($item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
            return $item;
        });

        $totalBayar = $items->sum('subtotal');
        $kembalian = $pjl->bayar - $totalBayar;

        session()->put('cart', $items);

        return view('penjualan.detailTransaksi', compact('pjl', 'cart', 'kembalian'));
    }

    public function loadCartDetail()
    {
        $cart = session()->get('cart', []);
        $output = '';
        $no = 1;
        if (empty($cart)) {
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        } else {
            $no = 1; // Inisialisasi nomor urutan
            foreach ($cart as $index => $item) {
                $output .= '
                <tr>
                    <td>' . $no++ . '</td>
                    <td><img src="' . asset($item['foto']) . '" alt="" width="100"></td>
                    <td style="width: 24%;">' . $item['name'] . '</td>
                    <td style="width: 23%;">' . $item['quantity'] . '</td>
                    <td style="width: 23%;">Rp ' . number_format($item['price'], 0, ',', '.') . '</td>
                    <td style="width: 23%;">Rp ' . number_format($item['subtotal'], 0, ',', '.') . '</td>
                </tr>';
            }
        }
        echo $output;
    }

    public function Nota($id)
    {
        // $id = decrypt($id);
        $cart = session()->get('cart', []);
        $pjl = Penjualan::where('no_penjualan', $id)->first();
        $DP = Detail_Produk::where('no_penjualan', $pjl->no_penjualan)->get();
        $DJ = Detail_Jasa::where('no_penjualan', $pjl->no_penjualan)->get();
        $type = '';

        $items = $DP->map(function ($item) use (&$type) {
            $type = "produk";
            return [
                'foto' => 'images/produk/' . $item->produk->foto,
                'name' => $item->produk->merek,
                'price' => $item->produk->harga,
                'type' => $type,
                'quantity' => $item->jumlah,
                'subtotal' => $item->produk->harga,
            ];
        })->concat($DJ->map(function ($item) use (&$type) {
            $type = "jasa";
            return [
                'foto' => 'images/jasa/' . $item->jasa->foto,
                'name' => $item->jasa->nama_jasa,
                'price' => $item->jasa->harga,
                'type' => $type,
                'quantity' => $item->jumlah,
                'subtotal' => $item->jasa->harga,
            ];
        }));

        $items->transform(function ($item) {
            $item['subtotal'] = $item['price'] * $item['quantity'];
            return $item;
        });

        $totalBayar = $items->sum('subtotal');
        $kembalian = $pjl->bayar - $totalBayar;

        session()->put('cart', $items);
        $pdf = new Tcpdf(PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $html = View('nota', compact('pjl', 'cart', 'kembalian', 'totalBayar'));
        $pdf->AddPage();
        $pdf->writeHTML($html);

        // Simpan PDF ke direktori public
        $pdfPath = public_path('images/nota/' . $id . '.pdf');
        $pdf->Output($pdfPath, 'F');
    }

    public function sendImageMessage($hp, $id)
    {
        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        $from = 'whatsapp:' . config('services.twilio.whatsapp_from');
        $to = 'whatsapp:' . '+62' . $hp;
        // dd($to);
        $mediaUrl = asset('images/nota/' . $id . '.pdf');
        $twilio->messages->create(
            $to,
            [
                'from' => $from,
                'mediaUrl' => $mediaUrl,
                'body' => 'Berikut adalah NOTA anda hari ini! 
                Terima kasih telah memakai jasa Kami 👏🙏'
            ]
        );

        // Setelah mengirim pesan, hapus file PDF
        $pdfPath = public_path('images/nota/' . $id . '.pdf');
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    }
}
