<?php

namespace App\Http\Controllers;

use App\Exports\reportPBL;
use App\Exports\reportPJL;
use App\Models\Detail_Jasa;
use App\Models\Detail_Produk;
use App\Models\Pegawai;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use TCPDF;
use Illuminate\Support\Facades\Response;

class C_Laporan extends Controller
{
    public function index()
    {
        return view('laporan');
    }

    public function penjualan(Request $request)
    {
        $tgl_awal =  $request->input('tgl_awal') ?: date('Y-m-01');
        $tgl_akhir = $request->input('tgl_akhir') ?: date('Y-m-t');

        $request->session()->put('tgl_awalPJL', $tgl_awal);
        $request->session()->put('tgl_akhirPJL', $tgl_akhir);

        $tgl1 = $tgl_awal;
        $tgl2 = $tgl_akhir;

        $laporan = Penjualan::whereBetween('created_at', [$tgl1, $tgl2 . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();

        foreach ($laporan as $item) {
            $pegawai = Pegawai::withTrashed()->where('no_pegawai', $item->no_pegawai)->first();
            if ($pegawai) {
                $item['nama_pegawai'] = $pegawai->nama;
                unset($item['no_pegawai']);
            }
        }

        $data = [
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2
            ],
            'data' => $laporan
        ];
        return response()->json($data);
    }

    public function filterPJL(Request $request)
    {
        return $this->penjualan($request);
    }

    public function pembelian(Request $request)
    {
        $tgl_awal =  $request->input('tgl_awal') ?: date('Y-m-01');
        $tgl_akhir = $request->input('tgl_akhir') ?: date('Y-m-t');

        $request->session()->put('tgl_awalPBL', $tgl_awal);
        $request->session()->put('tgl_akhirPBL', $tgl_akhir);

        $tgl1 = $tgl_awal;
        $tgl2 = $tgl_akhir;

        $laporan = Pembelian::whereBetween('created_at', [$tgl1, $tgl2 . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();

        foreach ($laporan as $item) {
            $pegawai = Pegawai::withTrashed()->where('no_pegawai', $item->no_pegawai)->first();
            if ($pegawai) {
                $item['nama_pegawai'] = $pegawai->nama;
                unset($item['no_pegawai']);
            }
        }

        $data = [
            'tanggal' => [
                'tgl_awal' => $tgl1,
                'tgl_akhir' => $tgl2
            ],
            'data' => $laporan
        ];
        return response()->json($data);
    }

    public function filterPBL(Request $request)
    {
        return $this->pembelian($request);
    }

    public function eksportPJL(Request $request)
    {
        $tgl_awal = $request->session()->get('tgl_awalPJL');
        $tgl_akhir = $request->session()->get('tgl_akhirPJL');

        return Excel::download(new reportPJL($tgl_awal, $tgl_akhir), 'LaporanPenjualan.xlsx');
    }

    public function eksportPBL(Request $request)
    {
        $tgl_awal = $request->session()->get('tgl_awalPBL');
        $tgl_akhir = $request->session()->get('tgl_akhirPBL');

        return Excel::download(new reportPBL($tgl_awal, $tgl_akhir), 'LaporanPembelian.xlsx');
    }

    public function detailPJL($id)
    {
        $id = base64_decode($id);
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

        return view('penjualan.detailTransaksi', compact('pjl', 'cart', 'kembalian'));
    }

    public function detailPBL($id)
    {
        $id = base64_decode($id);
        $pgw = Pegawai::all();
        $data = [
            'trs' => Pembelian::where('no_pembelian', $id)->first(),
            'produk' => Produk::all(),
        ];
        return view('pembelian.detailPembelian', compact('data', 'pgw'));
    }

    public function NotaPJL($id)
    {
        $id = base64_decode($id);
        $pjl = Penjualan::where('no_penjualan', $id)->first();
        $DP = Detail_Produk::where('no_penjualan', $id)->get();
        $DJ = Detail_Jasa::where('no_penjualan', $id)->get();
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
        $cart = $items;

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        // return View('nota', compact('pjl', 'cart', 'kembalian', 'totalBayar'));
        $html = View('nota.notaPJL', compact('pjl', 'cart', 'kembalian', 'totalBayar'));
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output($id . '.pdf', 'I');
    }

    public function notaPBL($id)
    {
        $id = base64_decode($id);
        $ukuran = 'P';
        $pbl = Pembelian::where('no_pembelian', $id)->first();
        $data = [
            'trs' => $pbl,
            'produk' => null,
        ];
        if ($pbl->kode_produk != null) {
            $data['produk'] = Produk::where('kode_produk', $pbl->kode_produk)->first();
            $ukuran = 'L';
        }
        $pdf = new TCPDF($ukuran, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);
        // return View('nota.notaPBL', compact('data'));
        $html = View('nota.notaPBL', compact('data'));
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $pdf->Output($id . '.pdf', 'I');
    }
}
