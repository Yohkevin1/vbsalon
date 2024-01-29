<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pembelian;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Pembelian extends Controller
{
    protected $validasi, $ResponValidasi, $validasiEdit, $ResponValidasiEdit;

    public function __construct()
    {
        $this->validasi = [
            'pegawai' => 'required',
            'no_pegawai' => 'required',
            'harga' => 'required|numeric',
            'keterangan' => function ($attribute, $value, $fail) {
                if (request('produk') === null && empty($value)) {
                    $fail('Keterangan wajib diisi jika produk tidak dipilih.');
                }
            }
        ];
        $this->ResponValidasi = [
            'pegawai.required' => 'Pegawai belum dipilih',
            'no_pegawai.required' => 'Pegawai belum dipilih',
            'harga.required' => 'Harga wajib diisi!',
            'harga.numeric' => 'Harga harus berupa angka!',
        ];
        $this->validasiEdit = [];
    }

    public function index()
    {
        $trs = Pembelian::whereBetween('created_at', [date('Y-m-01'), date('Y-m-t') . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
        return view('pembelian.indexTransaksi', compact('trs'));
    }

    public function storePembelian()
    {
        $prd = Produk::where('status', '!=', 'return')->get();
        $pgw = Pegawai::all();

        return view('pembelian.storePembelian', compact('prd', 'pgw'));
    }

    public function createPembelian(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = $this->generateID();
        Pembelian::insert([
            'no_pembelian' => $id,
            'no_pegawai' => $request->no_pegawai,
            'total_harga' => $request->harga,
            'keterangan' => $request->keterangan ?? null,
            'kode_produk' => $request->produk ?? null,
        ]);
        if ($request->produk != null) {
            Produk::where('kode_produk', $request->produk)->update([
                'status' => 'return',
            ]);
        }
        $request->session()->flash('message', 'Data Pembelian berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('pembelian')->withInput();
    }

    public function editPagePBL($id)
    {
        $id = decrypt($id);
        $pgw = Pegawai::all();
        $data = [
            'trs' => Pembelian::where('no_pembelian', $id)->first(),
            'produk' => Produk::all(),
        ];
        return view('pembelian.storeEditPembelian', compact('data', 'pgw'));
    }

    // blom kelar saveEdit
    public function editPBL(Request $request, $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Pembelian::where('no_pembelian', $id)->update([
            'no_pembelian' => $id,
            'no_pegawai' => $request->no_pegawai,
            'total_harga' => $request->harga,
            'keterangan' => $request->keterangan ?? null,
            'kode_produk' => $request->produk ?? null,
        ]);

        $request->session()->flash('message', 'Data Pembelian berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('pembelian')->withInput();
    }

    public function generateID()
    {
        $lastPembelian = Pembelian::orderBy('created_at', 'DESC')->first();
        $currentDate = now();
        $formattedDate = $currentDate->format('dmy');
        $no = 1;

        // Jika ada data ID Produk terakhir
        if ($lastPembelian) {
            // Menguraikan ID Produk terakhir dan mengambil bulannya
            $bulanTerakhir = substr($lastPembelian->no_pembelian, 5, 2); // Ambil bulan dari ID terakhir

            // Jika bulan terakhir sama dengan bulan sekarang
            if ($bulanTerakhir == $currentDate->format('m')) {
                // Increment nomor dari ID Pegawai terakhir
                $no = intval(substr($lastPembelian->no_pembelian, -5)) + 1;
            }
        }

        $noPenjualan = "PBL" . $formattedDate . str_pad($no, 5, '0', STR_PAD_LEFT);
        return $noPenjualan;
    }

    public function detailPBL($id)
    {
        $id = decrypt($id);
        $pgw = Pegawai::all();
        $data = [
            'trs' => Pembelian::withTrashed()->where('no_pembelian', $id)->first(),
            'produk' => Produk::all(),
        ];
        return view('pembelian.detailPembelian', compact('data', 'pgw'));
    }
}
