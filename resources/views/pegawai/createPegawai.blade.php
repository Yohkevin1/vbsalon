@extends('layout.main')
@section('title')
VB Salon | Create Pegawai
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
                <i class="fa-solid fa-user"></i>
                Tambah Pegawai
            </div>
            <div class="card-body">
                <!-- Form data -->
                <form action="{{ route('createPegawai') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row justify-content-center" >
                        <div class="col-sm-12" style="margin-bottom: 1rem">
                            <div class="mt-2 text-center">
                                <img src="{{ asset('images/pegawai/pegawai.svg') }}" alt="" class="img-thumbnail img-preview" style="max-width: 150px; max-height: 150px; border-radius: 50%;">
                            </div>
                        </div>
                        <label for="foto" class="col-sm-2 col-form-label">Foto Pegawai</label>
                        <div class="col-sm-10 text-center">
                            <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*" value="<?= old('foto') ?>" onchange="previewImage()">
                        </div>
                    </div>

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
                        <label for="tgl_lahir" class="col-sm-2 col-form-label">Tgl. Lahir</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= old('tgl_lahir') ?>" placeholder="Masukkan Tanggal Lahir">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="hp" class="col-sm-2 col-form-label">No. HP</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="hp" name="hp" value="<?= old('hp') ?>" placeholder="Masukkan No. Handphone">
                        </div>
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="role" id="roleSelect">
                                <option selected disabled value="">Pilih Role</option>
                                <?php foreach ($role as $kategori) : ?>
                                    <option value="<?= $kategori['id_role'] ?>"><?= $kategori['nama_role'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row" id="newUserSection" style="display: none;">
                        <label for="newUser" class="col-sm-3 col-form-label">Buat Akun Login Baru?</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="newUser" id="iya" value="Iya">
                                <label class="form-check-label" for="iya">Iya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="newUser" id="tidak" value="Tidak">
                                <label class="form-check-label" for="tidak">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-block">
                        <div class="justify-content-end d-flex" style="grid-gap: 1rem">
                            <a class="btn btn-danger ms-2" href="{{ route('pegawai') }}">Batal</a>
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