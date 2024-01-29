@extends('layout.main')
@section('title')
VB Salon | Store Pembelian
@endsection
@section('judul')
Store Pembelian
@endsection
@section('content')
<div class="row" style="color: black">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('storePembelian') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="col-form-label">Tanggal</label>
                            <input type="text" value="<?= date('l, d M Y') ?>" disabled class="form-control">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label class="col-form-label">Pegawai</label>
                            <input class="form-control" type="text" id="nama" value="{{ old('pegawai') }}" name="pegawai" readonly>
                            <input class="form-control" type="hidden" value="{{ old('no_pegawai') }}" name="no_pegawai" id="no_pegawai">
                        </div>
                    </div>
                    <div class="row mb-3" style="color: white">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <a class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#Pegawai">Pilih Pegawai</a>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga') ?>" placeholder="Masukkan harga">
                        </div>
                        <label for="produk" class="col-sm-2 col-form-label">Produk</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="produk" id="produkSelect">
                                <option selected disabled value="">Pilih Produk</option>
                                <?php foreach ($prd as $kategori) : ?>
                                    <option value="<?= $kategori['kode_produk'] ?>"><?= $kategori['merek'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" value="<?= old('keterangan') ?>" placeholder="Masukkan Keterangan Transaksi"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="{{ url()->previous() }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('pembelian.modalPegawai')


@endsection
