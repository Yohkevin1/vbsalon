@extends('layout.main')
@section('title')
VB Salon | Detail Pembelian
@endsection
@section('judul')
Detail Pembelian
@endsection
@section('content')
<div class="row" style="color: black">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="col-form-label">Tanggal</label>
                        <input type="text" value="<?= date('l, d M Y') ?>" disabled class="form-control">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="col-form-label">Pegawai</label>
                        <input class="form-control" type="text" id="nama" value="{{ $data['trs']->pegawai->nama}}" name="pegawai" readonly>
                        <input class="form-control" type="hidden" value="{{ $data['trs']['no_pegawai'] }}" name="no_pegawai" id="no_pegawai">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga', $data['trs']['total_harga']) ?>" readonly>
                    </div>
                    @if ($data['trs']['kode_produk']!=null)
                        <label for="produk" class="col-sm-2 col-form-label">Produk</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="harga" name="harga" value="<?= old('harga', $data['trs']->produk->merek) ?>" readonly>
                        </div>
                    @endif
                </div>
                <div class="mb-3 row">
                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="keterangan" name="keterangan" value="<?= old('keterangan',$data['trs']['keterangan'])?>" readonly>{{$data['trs']['keterangan']}}</textarea>
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
