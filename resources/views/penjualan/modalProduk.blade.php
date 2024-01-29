<!-- Modal Produk--->
<div class="modal fade" id="Produk" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Data Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="dataTable table table-hover table-responsive w-auto" style="color: black">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Merek</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($produk as $item)
                            <tr>
                                <th>{{$no++}}</th>
                                <th><img src="{{ asset('images/produk/' . $item->foto) }}" alt="" width="100"></th>
                                <th style="width: 30%;">{{ $item->merek }}</th>
                                <th style="width: 30%;">{{ $item->jumlah }}</th>
                                <th style="width: 30%;">Rp {{ number_format($item->harga, 0, ',', '.') }}</th>
                                <td style="width: 25%;">
                                    <button onclick="add_cart('{{ $item->kode_produk }}')" class="btn btn-success">
                                        <i class="fa fa-cart-plus"></i> Tambahkan</button>
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
    function add_cart(id) {
        var csrf_token = "{{ csrf_token() }}";
        $.ajax({
            url: "{{ route('addCart') }}",
            method: "POST",
            data: {
                id: id,
                _token: csrf_token
            },
            success: function(data) {
                load();
            }
        });
    }
</script>