@extends('layout.main')
@section('title')
VB Salon | Detail Penjualan
@endsection
@section('judul')
Detail Penjualan
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
                        <input type="hidden" id="no_penjualan" value="{{$pjl->no_penjualan}}" disabled class="form-control">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="col-form-label">Pegawai</label>
                        <input class="form-control" type="text" id="nama" value="{{$pjl->pegawai->nama}}" disabled>
                        <input class="form-control" type="hidden" id="no_pegawai" value="{{$pjl->no_pegawai}}">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="col-form-label">Telp Pelanggan:</label>
                        <input type="text" id="telp_pel" class="form-control" value="{{$pjl->telp_pelanggan ?: "Null"}}" disabled>
                    </div>
                </div>
                <table class="table table-striped table-hover table-responsive mt-4" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Produk / Jasa</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detail_cart">
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label class="col-form-label">Total bayar</label>
                        <h1><span id="spanTotal">0</span></h1>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label">Nominal</label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="nominal" value="{{ old('bayar', $pjl->bayar) }}" autocomplete="off" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label">Kembalian</label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="kembalian" value="{{ $kembalian}}" disabled>
                            </div>
                        </div>
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

<script>
    function load() {
        $('#detail_cart').load("{{ route('loadCartDetail') }}");
        $('#spanTotal').load("{{ route('getTotal') }}");
    }
    
    $(document).ready(function() {
        load();
    });
</script>

@endsection
