@extends('layout.main')
@section('title')
VB Salon | Create supplier
@endsection
@section('judul')
supplier
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4" style="color: black">
            <div class="card-header">
                <i class="fas fa-user-cog"></i>
                Tambah supplier
            </div>
            <div class="card-body">
                <!-- Form data -->
                <form action="{{ route('createSupplier') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="Masukkan Nama Pegawai">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea type="text" class="form-control" id="alamat" name="alamat" value="<?= old('alamat') ?>" placeholder="Masukkan Alamat"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="email" name="email" value="<?= old('email') ?>" placeholder="Masukkan Email">
                        </div>
                         <label for="telp" class="col-sm-2 col-form-label">No. Telp</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="telp" name="telp" value="<?= old('telp') ?>" placeholder="Masukkan No. Telepon">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="{{ route('supplier') }}">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
                <!-- end form -->
            </div>
        </div>
    </div>
</div>

<script>
    // Mengambil elemen select role
    var roleSelect = document.getElementById('roleSelect');
    
    // Mengambil elemen div untuk newUserSection
    var newUserSection = document.getElementById('newUserSection');

    // Menambahkan event listener untuk perubahan pada select role
    roleSelect.addEventListener('change', function() {
        // Menampilkan atau menyembunyikan newUserSection berdasarkan pilihan role
        if (roleSelect.value === '3') { // Ganti 'Pegawai' dengan nilai yang sesuai
            newUserSection.style.display = 'block'; // Menampilkan newUserSection
        } else {
            newUserSection.style.display = 'none'; // Menyembunyikan newUserSection
        }
    });
</script>

@endsection