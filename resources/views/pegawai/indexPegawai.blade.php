@extends('layout.main')
@section('title')
VB Salon | Pegawai
@endsection
@section('judul')
Pegawai
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                List Data Pegawai
            </div>
            <div class="card-body">
                <a href="{{ route('pegawaiPage') }}" class="btn btn-primary mb-3 btn-tambah"><i class="fas fa-plus-circle"></i> Tambah Pegawai</a>
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. Hp</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($pegawai as $item)
                            <tr>
                                <th>{{$no++}}</th>
                                <th><img src="{{ asset('images/pegawai/' . $item->foto) }}" alt="" width="100"></th>
                                <th>{{ $item->nama }}</th>
                                <th >{{ substr($item->alamat, 0, 200) }}</th>
                                <th>{{ $item->no_hp }}</th>
                                <th>
                                    @php
                                    $user = $user->firstWhere('id_user', $item->id_user);
                                    if ($user) {
                                        $role = $role->firstWhere('id_role', $user->id_role);
                                        if ($role) {
                                            echo $role->nama_role;
                                        } else {
                                            echo 'Role Tidak Ditemukan';
                                        }
                                    }
                                    @endphp
                                </th>
                                <td style="width: 20%">
                                    <a class="btn btn-warning text-white" href="{{ route('pegawaiEditPage', encrypt($item->no_pegawai)) }}">
                                        <i class="fas fa-pen-to-square"></i> Ubah
                                    </a>
                                    <a class="btn btn-danger text-white" href="#" data-toggle="modal" data-target="#deletePegawai{{ $item->no_pegawai }}">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </a>
                                    <a class="btn btn-secondary text-white" href="{{ route('detailPagePGW', encrypt($item->no_pegawai)) }}">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <!-- Delete Modal untuk Pegawai Tertentu -->
                            <div class="modal fade" id="deletePegawai{{ $item->no_pegawai }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Yakin data dihapus?</h5>
                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">Klik "hapus" di bawah ini jika Anda yakin ingin menghapus data {{$item->nama}}.</div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            <a class="btn btn-primary" href="{{ route('deletePegawai', encrypt($item->no_pegawai)) }}">Hapus</a>
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