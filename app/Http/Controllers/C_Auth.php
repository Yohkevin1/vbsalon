<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class C_Auth extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $dataLogin = $request->all();

        if (Auth::attempt(['username' => strtolower($dataLogin['username']), 'password' => $dataLogin['password']])) {
            $user = Auth::guard('web')->user();
            if ($user->username != 'pegawai')
                $pegawai = Pegawai::where('id_user', $user->id_user)->first();
        } else {
            $pegawai = Pegawai::where('email', $dataLogin['username'])->first();
            if (empty($pegawai))
                return redirect()->to('/login')->with('error', 'Username/Email dan Password Salah')->withInput();
            $user = User::where('id_user', $pegawai->id_user)->first();
            if (empty($pegawai) || !Hash::check($dataLogin['password'], $user->password))
                return redirect()->to('/login')->with('error', 'Username/Email dan Password Salah')->withInput();
        }

        $ses_data = [
            'username' => $user->username,
            'role' => Role::where('id_role', $user->id_role)->value('nama_role'),
        ];

        if ($user->username != 'pegawai') {
            $ses_data += [
                'no_pegawai' => $pegawai->no_pegawai,
                'foto' => '/images/pegawai/' . $pegawai->foto,
                'email' => $pegawai->email,
                'no_hp' => $pegawai->no_hp,
                'nama_depan' => explode(' ', $pegawai->nama)[0],
                'nama_blkng' => explode(' ', $pegawai->nama, 2)[1] ?? '',
            ];
        } else {
            $ses_data += [
                'foto' => '/images/pegawai/pegawai.svg',
            ];
        }

        $request->session()->put($ses_data);
        if (session('role') == 'pegawai')
            return redirect()->route('transaksi');
        else
            return redirect()->route('dashboard');
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = decrypt($id);
        $user = User::where('username', $id)->first();
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
        return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login');
    }
}
