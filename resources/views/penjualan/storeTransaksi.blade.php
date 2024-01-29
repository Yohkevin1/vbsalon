@extends('layout.main')
@section('title')
VB Salon | Store Penjualan
@endsection
@section('judul')
Store Penjualan
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
                        <input class="form-control" type="text" id="nama" disabled>
                        <input class="form-control" type="hidden" id="no_pegawai">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label class="col-form-label">Telp Pelanggan:</label>
                        <input type="text" id="telp_pel" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <button class="btn btn-primary" data-bs-target="#Produk" data-bs-toggle="modal">Pilih Produk</button>
                        <button class="btn btn-info" data-bs-target="#Jasa" data-bs-toggle="modal">Pilih Jasa</button>
                        <button class="btn btn-dark" data-bs-target="#Pegawai" data-bs-toggle="modal">Pilih Pegawai</button>
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
                            <th>Aksi</th>
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
                                <input type="text" class="form-control" id="nominal" autocomplete="off">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-4 col-form-label">Kembalian</label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="kembalian" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                    <button onclick="bayar()" class="btn btn-success me-md-2" type="button">Proses Bayar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@include('penjualan.modalProduk')
@include('penjualan.modalJasa')
@include('penjualan.modalPegawai')

<!-- Modal Update Jumlah--->
<div class="modal fade" id="Ubah" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Data Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Table Produk -->
                <div class="row mt-3">
                    <div class="col-sm-7">
                        <input type="hidden" id="id">
                        <input type="number" class="form-control" id="qty" placeholder="Masukkan jumlah produk" min="1" value="1">
                    </div>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" onclick="update_cart()"> Simpan</button>
                    </div>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</div>

<script>
    function load() {
        $('#detail_cart').load("{{ route('loadCart') }}");
        $('#spanTotal').load("{{ route('getTotal') }}");
    }
    
    $(document).ready(function() {
        load();
    });

    $(document).on('click', '.hapus_cart', function() {
        var id = $(this).attr("id"); 
        $.ajax({
            url: "{{ url('removeCart', )}}/" + id,
            type: "DELETE",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                load();
            },
        });
    });

    $(document).on('click', '.ubah_cart', function() {
        var id = $(this).attr("id");
        var qty = $(this).attr("qty");
        $('#id').val(id);
        $('#qty').val(qty);
        $('#Ubah').modal('show');
    });

    function update_cart() {
        var id = $('#id').val();
        var qty = $('#qty').val();
        $.ajax({
            url: "{{ route('updateCart') }}",
            method: "POST",
            data: {
                id: id,
                qty: qty,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                load();
                $('#Ubah').modal('hide');
            }
        });
    }

    function bayar() {
        var nominal = $('#nominal').val();
        var pegawai = $('#no_pegawai').val();
        var pelanggan = $('#telp_pel').val();
        $.ajax({
            url: "{{route('pembayaran')}}",
            method: "POST",
            data: {
                'nominal': nominal,
                'no_pegawai': pegawai,
                'telp_pel' : pelanggan,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                var result = JSON.parse(response);
                swal({
                    title: result.msg,
                    icon: result.status ? "success" : "error",
                });
                load();
                if (result.status) {
                    $('#nominal').val("");
                    $('#kembalian').val(result.data.kembalian);
                    setTimeout(function() {
                        location.reload();
                    }, 5000); // 5000 = 5 detik
                }
            }
        })
    }
</script>

@endsection
