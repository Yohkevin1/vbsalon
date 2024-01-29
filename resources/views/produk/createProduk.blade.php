@extends('layout.main')
@section('title')
VB Salon | Create Produk
@endsection
@section('judul')
Produk
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                <i class="fa-solid fa-scissors"></i>
                Tambah Produk
            </div>
            <div class="card-body">
                <!-- Form data -->
                <form action="{{ route('createProduk') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row justify-content-center" >
                        <div class="col-sm-12" style="margin-bottom: 1rem">
                            <div class="mt-2 text-center">
                                <img src="{{ asset('images/produk/produk.png') }}" alt="" class="img-thumbnail img-preview" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                            </div>
                        </div>
                        <label for="foto" class="col-sm-2 col-form-label">Foto Produk</label>
                        <div class="col-sm-10 text-center">
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" value="<?= old('foto') ?>" onchange="previewImage()">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="merek" class="col-sm-2 col-form-label">Merek</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="merek" name="merek" value="<?= old('merek') ?>" placeholder="Masukkan merek Jasa">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= old('deskripsi') ?>" placeholder="Masukkan Deskripsi Produk"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" placeholder="Masukkan jumlah">
                        </div>
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga') ?>" placeholder="Masukkan harga">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="supplier" id="supplierSelect">
                                <option selected disabled value="">Pilih Supplier</option>
                                <?php foreach ($supplier as $kategori) : ?>
                                    <option value="<?= $kategori['kode_supplier'] ?>"><?= $kategori['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="{{ route('produk') }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- end form -->
            </div>
        </div>
    </div>
</div>

@endsection