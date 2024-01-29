@extends('layout.main')
@section('title')
VB Salon | Detail Supplier
@endsection
@section('judul')
Detail Supplier
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-user-cog"></i>
                    Detail Supplier | {{$supplier->nama}}
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $supplier->nama) ?>" placeholder="Masukkan Nama supplier" disabled>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="alamat" name="alamat" value="<?= old('alamat') ?>" placeholder="Masukkan Alamat" disabled>{{$supplier->alamat}}</textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="email" name="email" value="<?= old('email', $supplier->email) ?>" placeholder="Masukkan Email" disabled>
                    </div>
                    <label for="telp" class="col-sm-2 col-form-label">No. Telp</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="telp" name="telp" value="<?= old('telp', $supplier->telp) ?>" placeholder="Masukkan No. Telepon" disabled>
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