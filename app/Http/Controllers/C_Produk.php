<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Produk extends Controller
{
    protected $validasi, $ResponValidasi;

    public function __construct()
    {
        $this->validasi = [
            'foto' => 'image|mimes:png,jpg|max:3072',
            'merek' => 'required|string|max:255',
            'deskripsi' => 'string',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
        ];

        $this->ResponValidasi = [
            'foto.image' => 'File yang diizinkan hanya PNG, JPG!',
            'foto.mimes' => 'Format file yang diizinkan hanya PNG, JPG!',
            'foto.max' => 'Ukuran file maksimal 3MB!',
            'merek.required' => 'Merk jasa wajib diisi!',
            'merek.max' => 'Merk jasa maksimal 255 karakter!',
            'jumlah.required' => 'Jumlah produk wajib diisi!',
            'jumlah.numeric' => 'Jumlah produk harus berupa angka!',
            'harga.required' => 'Harga wajib diisi!',
            'harga.numeric' => 'Harga harus berupa angka!',
        ];
    }

    public function index()
    {
        $produk = Produk::orderBy('created_at', 'ASC')->get();
        return view('produk.indexProduk', compact('produk'));
    }

    public function produkPage()
    {
        $supplier = Supplier::get();
        return view('produk.createProduk', compact('supplier'));
    }

    public function createProduk(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $foto = $request->file('foto');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move('images/produk/', $namaFile);
        } else {
            $namaFile = 'produk.png';
        }

        $id = $this->generateID();
        Produk::insert([
            'kode_produk' => $id,
            'foto' => $namaFile,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'kode_supplier' => $request->supplier ?? null,
            'status' => 'ready',
        ]);
        $request->session()->flash('message', 'Produk berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('produk')->withInput();
    }

    public function produkEditPage($id)
    {
        $id = decrypt($id);
        $produk = Produk::where('kode_produk', $id)->first();
        $supplier = Supplier::all();
        // dd($produk);
        return view('produk.updateProduk', compact('produk', 'supplier'));
    }

    public function editProduk(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $namaFileLama = $request->input('fotoLama');
        $foto = $request->file('foto');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move('images/produk/', $namaFile);
            if ($namaFileLama != 'produk.png' && $namaFileLama != "") {
                unlink('images/produk/' . $namaFileLama);
            }
        } else {
            $namaFile = $namaFileLama;
        }

        $id = decrypt($id); // Dekripsi ID jika perlu
        Produk::where('kode_produk', $id)->update([
            'kode_produk' => $id,
            'foto' => $namaFile,
            'merek' => $request->merek,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'kode_supplier' => $request->supplier ?? null,
            'status' => $request->status,
        ]);

        $request->session()->flash('message', 'Produk berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('produk')->withInput();
    }

    public function deleteProduk(Request $request, $id)
    {
        $id = decrypt($id);
        $produk = Produk::where('kode_produk', $id)->first();

        if ($produk->foto != 'produk.png') {
            unlink('images/produk/' . $produk->foto);
        }

        Produk::where('kode_produk', $id)->delete();

        $request->session()->flash('message', 'Data produk berhasil dihapus');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('produk')->withInput();
    }

    public function detailPage($id)
    {
        $id = decrypt($id);
        $produk = Produk::where('kode_produk', $id)->first();
        $supplier = Supplier::all();
        return view('produk.detailProduk', compact('produk', 'supplier'));
    }

    public function generateID()
    {
        $lastProduk = Produk::withTrashed()->orderBy('created_at', 'DESC')->first();
        $currentDate = now();
        $formattedDate = $currentDate->format('dmy');
        $no = 1;

        // Jika ada data ID Produk terakhir
        if ($lastProduk) {
            // Menguraikan ID Produk terakhir dan mengambil bulannya
            $bulanTerakhir = substr($lastProduk->kode_produk, 5, 2); // Ambil bulan dari ID terakhir

            // Jika bulan terakhir sama dengan bulan sekarang
            if ($bulanTerakhir == $currentDate->format('m')) {
                // Increment nomor dari ID Pegawai terakhir
                $no = intval(substr($lastProduk->kode_produk, -5)) + 1;
            }
        }

        $idPegawai = "PRD" . $formattedDate . str_pad($no, 5, '0', STR_PAD_LEFT);
        return $idPegawai;
    }
}
