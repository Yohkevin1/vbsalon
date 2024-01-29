<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Jasa extends Controller
{
    protected $validasi, $ResponValidasi;

    public function __construct()
    {
        $this->validasi = [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'string',
            'harga' => 'required|numeric',
        ];

        $this->ResponValidasi = [
            'nama.required' => 'Nama jasa wajib diisi!',
            'nama.max' => 'Nama jasa maksimal 255 karakter!',
            'harga.required' => 'Harga wajib diisi!',
            'harga.numeric' => 'Harga harus berupa angka!',
        ];
    }

    public function index()
    {
        $jasa = Jasa::orderBy('id_jasa', 'ASC')->get();
        return view('jasa.indexJasa', compact('jasa'));
    }

    public function jasaPage()
    {
        return view('jasa.createJasa');
    }

    public function createJasa(Request $request)
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
            $foto->move(public_path('images/jasa/'), $namaFile);
        } else {
            $namaFile = 'jasa.png';
        }

        Jasa::insert([
            'foto' => $namaFile,
            'nama_jasa' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);
        $request->session()->flash('message', 'Jasa berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('jasa')->withInput();
    }

    public function jasaEditPage($id)
    {
        $id = decrypt($id);
        $jasa = Jasa::where('id_jasa', $id)->first();
        return view('jasa.updateJasa', compact('jasa'));
    }

    public function editJasa(Request $request, $id)
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
            $foto->move('images/jasa/', $namaFile);
            if ($namaFileLama != 'jasa.png' && $namaFileLama != "") {
                unlink('images/jasa/' . $namaFileLama);
            }
        } else {
            $namaFile = $namaFileLama;
        }

        $id = decrypt($id); // Dekripsi ID jika perlu
        Jasa::where('id_jasa', $id)->update([
            'nama_jasa' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        $request->session()->flash('message', 'Data jasa berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('jasa')->withInput();
    }

    public function deleteJasa(Request $request, $id)
    {
        $id = decrypt($id);
        $jasa = Jasa::where('id_jasa', $id)->first();

        if ($jasa->foto != 'jasa.png') {
            unlink('images/jasa/' . $jasa->foto);
        }
        Jasa::where('id_jasa', $id)->delete();
        $request->session()->flash('message', 'Data jasa berhasil dihapus');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('jasa')->withInput();
    }

    public function detailPageJasa($id)
    {
        $id = decrypt($id);
        $jasa = Jasa::where('id_jasa', $id)->first();
        return view('jasa.detailJasa', compact('jasa'));
    }
}
