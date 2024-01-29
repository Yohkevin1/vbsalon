@extends('layout.main')
@section('title')
VB Salon | Detail Pegawai
@endsection
@section('judul')
Detail Pegawai
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-user"></i>
                    Detail Pegawai | {{$pegawai->nama}}
                </div>
            </div>
            <div class="card-body">
                <!-- Form data -->
                {{-- blom kelar --}}
                <form action="{{ route('editPegawai', encrypt($pegawai->no_pegawai)) }}" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3 row justify-content-center">
                        <div class="col-sm-12" style="margin-bottom: 1rem">
                            <div class="mt-2 text-center">
                                <img src="{{ asset('images/pegawai/'.$pegawai->foto) }}" alt="" class="img-thumbnail img-preview" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $pegawai->nama) ?>" placeholder="Masukkan Nama Pegawai" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="alamat" name="alamat" value="<?= old('alamat') ?>" placeholder="Masukkan Alamat" disabled>{{$pegawai->alamat}}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email" value="<?= old('email', $pegawai->email) ?>" placeholder="Masukkan Email" disabled>
                        </div>
                        <label for="tgl_lahir" class="col-sm-2 col-form-label">Tgl. Lahir</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= old('tgl_lahir', $pegawai->tgl_lahir) ?>" placeholder="Masukkan Tanggal Lahir" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hp" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="hp" name="hp" value="<?= old('hp', $pegawai->no_hp) ?>" placeholder="Masukkan No. Handphone" disabled>
                        </div>
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user->username) ?>" disabled>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-dark ms-2" href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection