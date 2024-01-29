<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembelian</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png')}}">
    <style>
        .barang {
            border-collapse: collapse;
            width: 100%;
        }
        .barang th {
            font-weight: bold !important;
            border: 1px solid black;
            padding: 8px;
        }
        .barang td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .dataPJL th {
            font-weight: bold !important;
            padding: 8px;
            text-align: left;
        }
        .dataPJL td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body style="color: black;">
    <h1 style="text-align: center">VENUS BEAUTY SALON</h1>
    <p style="text-align: center">No. Pembelian: {{ $data['trs']->no_pembelian }}</p>
    <div></div>
    <table class="dataPJL">
        <thead>
            <tr>
                <th style="width: 75%">Tanggal: </th>
                <th style="width: 25%">Pegawai: </th>
            </tr>
        </thead>
        <tbody> 
            <tr>
                <td style="width: 75%">{{ date('l, d F Y, H:i:s', strtotime($data['trs']->created_at)) }}</td>
                <td style="width: 25%">{{ $data['trs']->pegawai->nama }}</td>
            </tr>
        </tbody>
    </table>
    <div></div>
    @if ($data['produk'] != null)
        <div></div>
        <table class="barang" style="color: black;">
            <thead>
                <tr>
                    <th style="width: 15%; text-align: center;">Kode Produk</th>
                    <th style="width: 15%; text-align: center;">Foto</th>
                    <th style="width: 20%; text-align: center;">Merek</th>
                    <th style="width: 50%; text-align: center;">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 15%; text-align: left;">{{ $data['produk']->kode_produk }}</td>
                    <th style="width: 15%; text-align: left;">
                        <img src="{{ public_path('images/produk/' . $data['produk']->foto) }}" alt="" width="100">
                    </th>
                    <td style="width: 20%; text-align: left;">{{ $data['produk']->merek }}</td>
                    <td style="width: 50%; text-align: left;">{{ $data['produk']->deskripsi}}</td>
                </tr>
            </tbody>
        </table>
        <div></div>
        <div></div>
    @endif
    <table class="dataPJL">
        <thead>
            <tr>
                <th style="width: 75%">Keterangan: </th>
                <th style="width: 25%">Total Tagihan: </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 75%"><span>{{ $data['trs']->keterangan}}</span></td>
                <td style="width: 25%"><span>{{ "Rp. " . number_format($data['trs']->total_harga, 0, ',', '.') }}</span></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
