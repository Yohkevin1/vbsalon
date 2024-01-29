<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Supplier extends Controller
{
    protected $validasi, $ResponValidasi, $validasiEdit;

    public function __construct()
    {
        $this->validasi = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers|max:255',
            'telp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/'],
        ];
        $this->ResponValidasi = [
            'nama.required' => 'Nama pegawai wajib diisi!',
            'nama.max' => 'Nama pegawai maksimal 255 karakter!',
            'alamat.required' => 'Alamat pegawai wajib diisi!',
            'alamat.max' => 'Alamat pegawai maksimal 255 karakter!',
            'email.required' => 'Email pegawai wajib diisi!',
            'email.max' => 'Email pegawai maksimal 255 karakter!',
            'email.email' => 'Email tidak valid!',
            'telp.required' => 'No telp Wajib Di Isi!!',
            'telp.max' => 'No telp maksimal 15 karakter!',
            'telp.regex' => 'Format No telp tidak valid!',
        ];
        $this->validasiEdit = [
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/'],
        ];
    }
    public function index()
    {
        $supplier = Supplier::orderBy('created_at', 'ASC')->get();
        return view('supplier.indexSupplier', compact('supplier'));
    }

    public function supplierPage()
    {
        return view('supplier.createSupplier');
    }

    public function createSupplier(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $this->generateID();
        // dd($lastSupplier);   
        Supplier::insert([
            'kode_supplier' => $id,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);

        $request->session()->flash('message', 'Pegawai berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('supplier')->withInput();
    }

    public function supplierEditPage($id)
    {
        $id = decrypt($id);
        $supplier = Supplier::where('kode_supplier', $id)->first();
        return view('supplier.updateSupplier', compact('supplier'));
    }

    public function editSupplier(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validasiEdit, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = decrypt($id); // Dekripsi ID jika perlu
        Supplier::where('kode_supplier', $id)->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
        ]);

        $request->session()->flash('message', 'Pegawai berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('supplier')->withInput();
    }

    public function deleteSupplier(Request $request, $id)
    {
        $id = decrypt($id);
        Supplier::where('kode_supplier', $id)->delete();
        $request->session()->flash('message', 'Data supplier berhasil dihapus');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('supplier')->withInput();
    }

    public function detailPageSPL($id)
    {
        $id = decrypt($id);
        $supplier = Supplier::where('kode_supplier', $id)->first();
        return view('supplier.detailSupplier', compact('supplier'));
    }

    public function generateID()
    {
        $lastSupplier = Supplier::withTrashed()->orderBy('created_at', 'DESC')->first();
        $currentDate = now();
        $formattedDate = $currentDate->format('dmy');
        $no = 1;

        // Jika ada data ID Pegawai terakhir
        if ($lastSupplier) {
            // Menguraikan ID Pegawai terakhir dan mengambil bulannya
            $bulanTerakhir = substr($lastSupplier->kode_supplier, 5, 2); // Ambil bulan dari ID terakhir

            // Jika bulan terakhir sama dengan bulan sekarang
            if ($bulanTerakhir == $currentDate->format('m')) {
                // Increment nomor dari ID Pegawai terakhir
                $no = intval(substr($lastSupplier->kode_supplier, -5)) + 1;
            }
        }

        $kode_supplier = "SPR" . $formattedDate . str_pad($no, 5, '0', STR_PAD_LEFT);
        return $kode_supplier;
    }
}
