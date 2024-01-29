@extends('layout.main')
@section('title')
VB Salon | Update Pegawai
@endsection
@section('judul')
Update Pegawai
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-user"></i>
                    Edit Pegawai | {{$pegawai->nama}}
                </div>
                @if ($pegawai->id_user != 1 && $pegawai->id_user != 2 && $pegawai->id_user != 3)
                    <a class="btn btn-secondary" href="#" data-toggle="modal" data-target="#resetPassPGW">Reset Pass</a>
                @endif
            </div>
            <div class="card-body">
                <!-- Form data --> 
                {{-- blom kelar --}}
                <form action="{{ route('editPegawai', encrypt($pegawai->no_pegawai)) }}" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3 row justify-content-center" >
                        <div class="col-sm-12" style="margin-bottom: 1rem">
                            <div class="mt-2 text-center">
                                <img src="{{ asset('images/pegawai/'.$pegawai->foto) }}" alt="" class="img-thumbnail img-preview" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                            </div>
                        </div>
                        <label for="foto" class="col-sm-2 col-form-label">Foto Pegawai</label>
                        <div class="col-sm-10 text-center">
                            <input type="hidden" name="fotoLama" value="{{$pegawai->foto}}">
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" value="<?= old('foto') ?>" onchange="previewImage()">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $pegawai->nama) ?>" placeholder="Masukkan Nama Pegawai">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="alamat" name="alamat" value="<?= old('alamat') ?>" placeholder="Masukkan Alamat">{{$pegawai->alamat}}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email" value="<?= old('email', $pegawai->email) ?>" placeholder="Masukkan Email">
                        </div>
                        <label for="tgl_lahir" class="col-sm-2 col-form-label">Tgl. Lahir</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= old('tgl_lahir', $pegawai->tgl_lahir) ?>" placeholder="Masukkan Tanggal Lahir">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hp" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="hp" name="hp" value="<?= old('hp', $pegawai->no_hp) ?>" placeholder="Masukkan No. Handphone">
                        </div>
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user->username)?>" disabled>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="{{ route('pegawai') }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- end form -->
            </div>
        </div>
    </div>
</div>

{{-- Reset Pass Modal --}}
<div class="modal fade" id="resetPassPGW" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content" style="max-width: 90%; margin: 0 auto;">
            <div class="modal-header bg-gradient-danger justify-content-center">
                <h4 class="modal-title" style="color: white">Reset Password</h4>
            </div>
            <div class="modal-body text-dark">
                <form action="{{ route('resetPass', encrypt($pegawai->id_user))}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div style="margin-bottom: 10px">
                                <label class="form-label" for="oldPassword">Password lama</label>
                                <input type="password" class="form-control" name="oldPassword" placeholder="Masukkan password lama" required>
                            </div>
                            <div style="margin-bottom: 10px">
                                <label class="form-label" for="newPassword">Password Baru</label>
                                <input type="password" class="form-control" name="newPassword" placeholder="Masukkan password baru" required>
                            </div>
                            <div style="margin-bottom: 10px">
                                <label class="form-label" for="confirmPassword">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="confirmPassword" placeholder="Masukkan ulang password baru" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection