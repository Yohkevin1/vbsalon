<!-- Modal Pegawai--->
<div class="modal fade" id="Pegawai" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Data Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            {{-- <th>No</th> --}}
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php $no = 1; @endphp --}}
                        @foreach ($pgw as $item)
                        <tr>
                            {{-- <th>{{$no++}}</th> --}}
                            <th><img src="{{ asset('images/pegawai/' . $item->foto) }}" alt="" width="100"></th>
                            <th style="width: 30%;">{{ $item->nama }}</th>
                            <td style="width: 25%;">
                                <button onclick="selectPegawai('{{ $item->no_pegawai }}','{{$item->nama}}')" class="btn btn-success">
                                    <i class="fa-solid fa-hand-pointer"></i>Tambahkan</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    function selectPegawai(id, nama) {
        $('#no_pegawai').val(id);
        $('#nama').val(nama);
        $('#Pegawai').modal('hide');
    }
</script>