<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Role;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class C_Pegawai extends Controller
{
    protected $validasi, $ResponValidasi, $validasiEdit, $ResponValidasiEdit;

    public function __construct()
    {
        $this->validasi = [
            'foto' => 'image|mimes:png,jpg|max:3072',
            'nama' => 'required|string|max:255|unique:pegawai',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai|max:255',
            'tgl_lahir' => 'required|date',
            'hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/'],
            'role' => 'required|exists:roles,id_role',
        ];
        $this->ResponValidasi = [
            'foto.image' => 'File yang diizinkan hanya PNG, JPG!',
            'foto.mimes' => 'Format file yang diizinkan hanya PNG, JPG!',
            'foto.max' => 'Ukuran file maksimal 3MB!',
            'nama.required' => 'Nama pegawai wajib diisi!',
            'nama.max' => 'Nama pegawai maksimal 255 karakter!',
            'alamat.required' => 'Alamat pegawai wajib diisi!',
            'alamat.max' => 'Alamat pegawai maksimal 255 karakter!',
            'email.required' => 'Email pegawai wajib diisi!',
            'email.max' => 'Email pegawai maksimal 255 karakter!',
            'email.email' => 'Email tidak valid!',
            'tgl_lahir.required' => 'Tanggal lahir pegawai wajib diisi!',
            'tgl_lahir.date' => 'Tanggal lahir harus berupa tanggal!',
            'hp.required' => 'No HP Wajib Di Isi!!',
            'hp.max' => 'No HP maksimal 15 karakter!',
            'hp.regex' => 'Format No HP tidak valid!',
            'role.required' => 'Role pegawai wajib diisi!',
            'role.exists' => 'Role yang dipilih tidak valid!'
        ];
        $this->validasiEdit = [
            'foto' => 'image|mimes:png,jpg|max:3072',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tgl_lahir' => 'required|date',
            'hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/'],
        ];
    }

    public function index()
    {
        $pegawai = Pegawai::orderBy('created_at', 'ASC')->get();
        $role = Role::all();
        $user = User::all();
        return view('pegawai.indexPegawai', compact('pegawai', 'role', 'user'));
    }

    public function pegawaiPage()
    {
        $role = Role::where('deleted_at', NULL)->get();
        return view('pegawai.createPegawai', compact('role'));
    }

    public function createPegawai(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validasi, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->role == 3 && $request->newUser == "Tidak") {
            $user = User::where('username', 'pegawai')->first();
        } else {
            $namaArray = explode(' ', $request->nama);
            $namaDepan = $namaArray[0] . $namaArray[1];
            User::insert([
                'username' => $namaDepan,
                'password' => Hash::make($request->tgl_lahir),
                'id_role' => $request->role,
            ]);
            $user = User::where('username', $namaDepan)->first();
        }

        $foto = $request->file('foto');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move(public_path('images/pegawai/'), $namaFile);
        } else {
            $namaFile = 'pegawai.svg';
        }

        $id = $this->generateID();
        Pegawai::insert([
            'no_pegawai' => $id,
            'foto' => $namaFile,
            'nama' => $request->nama,
            'email' => $request->email,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->hp,
            'id_user' => $user->id_user,
        ]);

        $request->session()->flash('message', 'Pegawai berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('pegawai')->withInput();
    }

    public function pegawaiEditPage($id)
    {
        $id = decrypt($id);
        $role = Role::get();
        $pegawai = Pegawai::where('no_pegawai', $id)->first();
        $user = User::where('id_user', $pegawai->id_user)->first();
        return view('pegawai.updatePegawai', compact('role', 'pegawai', 'user'));
    }

    public function editPegawai(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validasiEdit, $this->ResponValidasi);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (strcasecmp($request->nama, 'owner') === 0 || strcasecmp($request->nama, 'admin') === 0 || strcasecmp($request->nama, 'pegawai') === 0) {
            $request->session()->flash('message', 'Nama tidak boleh owner, admin, pegawai');
            $request->session()->flash('alert-type', 'error');
            return redirect()->back();
        }

        $namaFileLama = $request->input('fotoLama');
        $foto = $request->file('foto');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move('images/pegawai/', $namaFile);
            if ($namaFileLama != 'pegawai.svg' && $namaFileLama != "") {
                unlink('images/pegawai/' . $namaFileLama);
            }
        } else {
            $namaFile = $namaFileLama;
        }

        $id = decrypt($id); // Dekripsi ID jika perlu
        $pegawai = Pegawai::where('no_pegawai', $id)->first();
        $user = User::where('id_user', $pegawai->id_user)->first(); // Ganti ini dengan cara yang sesuai untuk mendapatkan data pengguna
        if (empty($user)) {
            $request->session()->flash('message', 'Pegawai tidak ditemukan');
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withInput();
        }

        Pegawai::where('no_pegawai', $id)->update([
            'foto' => $namaFile,
            'nama' => $request->nama,
            'email' => $request->email,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'no_hp' => $request->hp,
            'id_user' => $user->id_user,
        ]);

        $request->session()->flash('message', 'Pegawai berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('pegawai')->withInput();
    }

    public function resetPass(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'oldPassword' => 'required',
                'newPassword' => 'required|min:10|same:confirmPassword|regex:/^(?:(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{10,})$/',
                'confirmPassword' => 'required',
            ],
            [
                'oldPassword.required' => 'Masukkan password lama anda',
                'newPassword.required' => 'Masukkan password terbaru',
                'newPassword.min' => 'Password minimal 10 karakter',
                'newPassword.same' => 'Password Confrimation tidak cocok',
                'confirmPassword.required' => 'Password Konfirmasi diperlukan',
                'newPassword.regex' => 'Password harus mengandung minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->route('dashboard')->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        $user = User::where('id_user', $id)->first();
        $verify_pass = Hash::check($request['oldPassword'], $user->password,);
        if (!$verify_pass) {
            $request->session()->flash('message', 'Password lama salah');
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withInput();
        }

        User::where('id_user', $user->id_user)->update([
            'password' => Hash::make($request->newPassword),
        ]);
        $request->session()->flash('message', 'Password berhasil diubah');
        $request->session()->flash('alert-type', 'success');
        return redirect()->to('pegawai');
    }

    public function deletePegawai(Request $request, $id)
    {
        $id = decrypt($id);
        $pegawai = Pegawai::where('no_pegawai', $id)->first();
        if (in_array($pegawai->nama, ['Owner', 'Admin', 'Pegawai'])) {
            $request->session()->flash('message', 'Data pegawai ini tidak bisa dihapus');
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withInput();
        }

        if ($pegawai->foto != 'pegawai.svg') {
            unlink('images/pegawai/' . $pegawai->foto);
        }

        // Hapus pegawai
        Pegawai::where('no_pegawai', $id)->delete();

        $user = User::where('id_user', $pegawai->id_user)->first();
        if ($user && !in_array($user->username, ['Owner', 'Admin', 'Pegawai'])) {
            User::where('id_user', $pegawai->id_user)->delete();
        }
        $request->session()->flash('message', 'Data pegawai berhasil dihapus');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('pegawai')->withInput();
    }

    public function detailPagePGW($id)
    {
        $id = decrypt($id);
        $role = Role::get();
        $pegawai = Pegawai::where('no_pegawai', $id)->first();
        $user = User::where('id_user', $pegawai->id_user)->first();
        return view('pegawai.detailPegawai', compact('role', 'pegawai', 'user'));
    }

    public function generateID()
    {
        $lastPegawai = Pegawai::withTrashed()->orderBy('created_at', 'DESC')->first();
        $currentDate = now();
        $formattedDate = $currentDate->format('dmy');
        $no = 1;

        // Jika ada data ID Pegawai terakhir
        if ($lastPegawai) {
            // Menguraikan ID Pegawai terakhir dan mengambil bulannya
            $bulanTerakhir = substr($lastPegawai->no_pegawai, 5, 2); // Ambil bulan dari ID terakhir

            // Jika bulan terakhir sama dengan bulan sekarang
            if ($bulanTerakhir == $currentDate->format('m')) {
                // Increment nomor dari ID Pegawai terakhir
                $no = intval(substr($lastPegawai->no_pegawai, -5)) + 1;
            }
        }

        $idPegawai = "PGW" . $formattedDate . str_pad($no, 5, '0', STR_PAD_LEFT);
        return $idPegawai;
    }
}
