@extends('layout.main')
@section('title')
VB Salon | Detail Jasa
@endsection
@section('judul')
Detail Jasa
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fa-solid fa-scissors"></i>
                    Detail Jasa | {{$jasa->nama_jasa}}
                </div>
            </div>
            <div class="card-body">
                    <div class="mb-3 row justify-content-center">
                        <div class="col-sm-12" style="margin-bottom: 1rem">
                            <div class="mt-2 text-center">
                                <img src="{{ asset('images/jasa/'.$jasa->foto) }}" alt="" class="img-thumbnail img-preview" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama', $jasa->nama_jasa) ?>" placeholder="Masukkan Nama jasa" disabled>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskipsi</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= old('deskripsi') ?>" placeholder="Masukkan deskripsi" disabled>{{$jasa->deskripsi}}</textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga', $jasa->harga) ?>" placeholder="Masukkan Email" disabled>
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