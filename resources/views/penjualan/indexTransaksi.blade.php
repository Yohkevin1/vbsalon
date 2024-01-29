@extends('layout.main')
@section('title')
VB Salon | Transaksi Penjualan
@endsection
@section('judul')
Transaksi Penjualan
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                List Data Penjualan
            </div>
            <div class="card-body">
                <a href="{{ route('storeTransaksi') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Transaksi</a>
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nota</th>
                            <th>Melayani</th>
                            <th>Telp. Pelanggan</th>
                            <th>Total Harga</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($trs as $item)
                            <tr>
                                <th>{{$no++}}</th>
                                <th style="width: 15%">{{ $item->no_penjualan}}</th>
                                <th style="width: 15%">{{ optional($item->pegawai)->nama?: $item->no_pegawai }}</th>
                                <th style="width: 15%">{{ $item->telp_pelanggan ?:"Null"}}</th>
                                <th style="width: 20%">Rp {{ number_format($item->total_harga, 2, ',', '.') }}</th>
                                <th style="width: 20%">Rp {{ number_format($item->bayar, 2, ',', '.') }}</th>
                                <td style="width: 20%">
                                    @if (session('role')== 'owner' || session('role')== 'admin')
                                        <a class="btn btn-warning text-white" href="{{ route('editPagePJL', encrypt($item->no_penjualan)) }}">
                                            <i class="fas fa-pen-to-square"></i> Ubah
                                        </a>
                                    @endif
                                    <a class="btn btn-secondary text-white" href="{{ route('detailPJL', encrypt($item->no_penjualan)) }}">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
@endsection