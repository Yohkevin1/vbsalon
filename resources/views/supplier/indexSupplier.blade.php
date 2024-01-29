@extends('layout.main')
@section('title')
VB Salon | Supplier
@endsection
@section('judul')
Supplier
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                List Data Supplier
            </div>
            <div class="card-body">
                <a href="{{ route('supplierPage') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Supplier</a>
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($supplier as $item)
                            <tr>
                                <th >{{$no++}}</th>
                                <th>{{ $item->nama }}</th>
                                <th>{{ $item->email }}</th>
                                <th>{{ substr($item->alamat, 0, 100) }}</th>
                                <th>{{ $item->telp }}</th>
                                <td style="width: 20%">
                                    <a class="btn btn-warning text-white" href="{{ route('supplierEditPage', encrypt($item->kode_supplier)) }}">
                                        <i class="fas fa-pen-to-square"></i> Ubah
                                    </a>
                                    <a class="btn btn-danger text-white" href="#" data-toggle="modal" data-target="#deleteModal{{ $item->kode_supplier }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
                                    <a class="btn btn-secondary text-white" href="{{ route('detailPageSPL', encrypt($item->kode_supplier)) }}">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <!-- Delete Modal untuk Supplier Tertentu -->
                            <div class="modal fade" id="deleteModal{{ $item->kode_supplier }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->nama }}.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a class="btn btn-primary" href="{{ route('deleteSupplier', encrypt($item->kode_supplier)) }}">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
@endsection