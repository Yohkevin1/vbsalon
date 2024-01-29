@extends('layout.main')
@section('title')
VB Salon | Jasa
@endsection
@section('judul')
Jasa
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                List Data Jasa
            </div>
            <div class="card-body">
                <a href="{{ route('jasaPage') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Jasa</a>
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Jasa</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($jasa as $item)
                            <tr>
                                <th>{{$no++}}</th>
                                <th style="width: 15%"><img src="{{ asset('images/jasa/' . $item->foto) }}" alt="" width="100"></th>
                                <th style="width: 15%">{{ $item->nama_jasa }}</th>
                                <th style="width: 20%">{{ substr($item->deskripsi, 0, 200) }}</th>
                                <th style="width: 20%">Rp {{ number_format($item->harga, 2, ',', '.') }}</th>
                                <td>
                                    <a class="btn btn-warning text-white" href="{{ route('jasaEditPage', encrypt($item->id_jasa)) }}">
                                        <i class="fas fa-pen-to-square"></i> Ubah
                                    </a>
                                    <a class="btn btn-danger text-white" href="#" data-toggle="modal" data-target="#deleteModal{{ $item->id_jasa }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
                                    <a class="btn btn-secondary text-white" href="{{ route('detailPageJasa', encrypt($item->id_jasa)) }}">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                </td>
                            </tr>

                            <!-- Delete Modal untuk Pegawai Tertentu -->
                            <div class="modal fade" id="deleteModal{{ $item->id_jasa }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{ $item->nama_jasa }}.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a class="btn btn-primary" href="{{ route('deleteJasa', encrypt($item->id_jasa)) }}">Hapus</a>
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