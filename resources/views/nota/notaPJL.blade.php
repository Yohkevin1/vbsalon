<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembayaran</title>
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
    <p style="text-align: center">No. Penjualan: {{ $pjl->no_penjualan }}</p>
    <div></div>
    <table class="dataPJL">
        <thead>
            <tr>
                <th style="width: 40%">Tanggal: </th>
                <th style="width: 30%">Pegawai: </th>
                <th style="width: 30%">Telp. Pelanggan: </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 40%">{{ date('l, d F Y, H:i:s', strtotime($pjl->created_at)) }}</td>
                <td style="width: 30%">{{ $pjl->pegawai->nama }}</td>
                <td style="width: 30%">{{ $pjl->telp_pelanggan != "NULL" ? $pjl->telp_pelanggan : "" }}</td>
            </tr>
        </tbody>
    </table>
    <div></div>
    <div></div>
    <table class="barang" style="color: black;">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 50%; text-align: center;">Produk / Jasa</th>
                <th style="width: 14%; text-align: center;">Jumlah</th>
                <th style="width: 15%; text-align: center;">Satuan</th>
                <th style="width: 15%; text-align: center;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($cart as $item)
            <tr>
                <td style="width: 6%; text-align: center;">{{ $no++ }}</td>
                <td style="width: 50%; text-align: center;">{{ $item['name'] }}</td>
                <td style="width: 14%; text-align: center;">{{ $item['quantity'] }}</td>
                <td style="width: 15%; text-align: center;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                <td style="width: 15%; text-align: center;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div></div>
    <div></div>
    <table class="dataPJL">
        <thead>
            <tr>
                <th style="width: 40%">Kembalian: </th>
                <th style="width: 30%">Uang Pembayaran: </th>
                <th style="width: 30%">Total Tagihan: </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 40%"><span>{{ "Rp. " . number_format($kembalian, 0, ',', '.') }}</span></td>
                <td style="width: 30%"><span>{{ "Rp. " . number_format($pjl->bayar, 0, ',', '.') }}</span></td>
                <td style="width: 30%"><span>{{ "Rp. " . number_format($totalBayar, 0, ',', '.') }}</span></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
