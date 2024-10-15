@extends('layout.main')
@section('title')
VB Salon | Laporan
@endsection
@section('judul')
Laporan
@endsection
@section('content')
<!-- Page Heading -->
<div class="row">
    <div class="col-md-12">
        <button onclick="pjl()" id="btn_penjualan" style="color: white" class="btn btn-success mb-3" type="button"> Laporan Penjualan</button>
        <button onclick="pbl()" id="btn_pembelian" style="color: white" class="btn btn-primary mb-3" type="button"> Laporan Pembelian</button>
        <button onclick="grafik()" id="btn_grafik" style="color: white" class="btn btn-dark mb-3" type="button"> Grafik Laporan</button>
    </div>
</div>

<div id="penjualan-table" class="card mb-4" style="color: black">
    <div class="card-header">
        Laporan Penjualan
    </div>
    <div class="card-body">
        <div class="row" id="filterPJL">
        </div>
        <br>
        <a class="btn btn-dark mb-3" type="button" href="{{ route('penjualanExport') }}">Export Excel</a>
        <table id="tableTotalLaporan_PJL" class="table table-hover table-responsive w-auto" style="color: black">
            <thead>
                <tr>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="total">
            </tbody>
        </table>
        <table id="tableLaporan_PJL" class="table table-hover table-responsive w-auto" style="color: black">
            <div class="mb-3">
                <input type="text" id="searchPenjualan" class="form-control" placeholder="Cari Penjualan">
            </div>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nota</th>
                    <th>Tgl Transaksi</th>
                    <th>User</th>
                    <th>Telp Pelanggan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="laporan_PJL">
            </tbody>
        </table>
    </div>
</div>

<div id="pembelian-table" class="card mb-4" style="color: black">
    <div class="card-header">
        Laporan Pembelian
    </div>
    <div class="card-body">
        <div class="row" id="filterPBL">
        </div>
        <br>
        <a class="btn btn-dark mb-3" type="button" href="{{ route('pembelianExport') }}">Export Excel</a>
        <table id="tableTotalLaporan_PBL" class="table table-hover table-responsive w-auto" style="color: black">
            <thead>
                <tr>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="total_pbl">
            </tbody>
        </table>
        <table id="tableLaporan_PBL" class="table table-hover table-responsive w-auto" style="color: black">
            <div class="mb-3">
                <input type="text" id="searchPembelian" class="form-control" placeholder="Cari Pembelian">
            </div>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nota</th>
                    <th>Tgl Transaksi</th>
                    <th>User</th>
                    <th>Telp Pelanggan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="laporan_PBL">
            </tbody>
        </table>
    </div>
</div>

<div id="grafik_laporan">
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penerimaan & Pengeluaran</h6>
                    <div class="col-sm-auto">
                        <div class="input-group">
                            <input type="number" id="tahun" class="form-control" value="<?= date('Y') ?>" onchange="TrsByYears()">
                        </div>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Download Grafik:</div>
                            {{-- <div class="dropdown-divider"></div> --}}
                            <button class="dropdown-item" onclick="downloadLineChart('PDF')">PDF</button>
                            <button class="dropdown-item" onclick="downloadLineChart('PNG')">PNG</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body" style="display: flex; flex-direction: column; align-items: center;">
                    <div class="chart-area">
                        <canvas id="LinePBLvsPJL"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row"> 
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Income</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Download Grafik:</div>
                            <button class="dropdown-item" onclick="downloadPie_PrdJasa('PDF')">PDF</button>
                            <button class="dropdown-item" onclick="downloadPie_PrdJasa('PNG')">PNG</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="Prd_Jasa"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                    </div>
                    <div class="col-lg-12 col-md-4 col-sm-6 mx-auto mt-3" style="text-align: center;">
                        <div class="input-group">
                            <input type="number" id="tahun-prdjasa" class="form-control" value="<?= date('Y') ?>" onchange="IncomePrd_Jasa()">
                            <select id="bulan_PrdJasa" class="form-control" onchange="IncomePrd_Jasa()">
                                <option value="1" {{ date('n') == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="2" {{ date('n') == 2 ? 'selected' : '' }}>Februari</option>
                                <option value="3" {{ date('n') == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="4" {{ date('n') == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ date('n') == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="6" {{ date('n') == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ date('n') == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ date('n') == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="9" {{ date('n') == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ date('n') == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ date('n') == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ date('n') == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Income </h6>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="number" id="tahun-income" class="form-control" value="<?= date('Y') ?>" onchange="PieChartIncome()">
                        </div>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Download Grafik:</div>
                            <button class="dropdown-item" onclick="downloadPieIncome('PDF')">PDF</button>
                            <button class="dropdown-item" onclick="downloadPieIncome('PNG')">PNG</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie ">
                        <canvas id="incomePie"></canvas>
                    </div>
                    <div class="col-lg-12 col-md-4 col-sm-6 mx-auto mt-3" style="text-align: center;">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Outcome </h6>
                    <div class="col-sm-5">
                        <div class="input-group">
                            <input type="number" id="tahun-outcome" class="form-control" value="<?= date('Y') ?>" onchange="PieChartOutcome()">
                        </div>
                    </div>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Download Grafik:</div>
                            <button class="dropdown-item" onclick="downloadPieOutcome('PDF')">PDF</button>
                            <button class="dropdown-item" onclick="downloadPieOutcome('PNG')">PNG</button>
                        </div>
                    </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="outcomePie"></canvas>
                    </div>
                    <div class="col-lg-12 col-md-4 col-sm-6 mx-auto mt-3" style="text-align: center;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const btnPenjualan = document.getElementById('btn_penjualan');
    const btnPembelian = document.getElementById('btn_pembelian');
    const btnGrafik = document.getElementById('btn_grafik');

    const PenjualanTable = document.getElementById('penjualan-table');
    const PembelianTable = document.getElementById('pembelian-table');
    const GrafikLaporan = document.getElementById('grafik_laporan');

    PenjualanTable.style.display = 'none';
    PembelianTable.style.display = 'none';
    GrafikLaporan.style.display = 'none';
    
    function pbl(){
        PenjualanTable.style.display = 'none';
        PembelianTable.style.display = 'block';
        GrafikLaporan.style.display = 'none';
        $.get('{{ route('laporanPembelian') }}', function (data) {
            templetPBL(data);
        });
    }
    
    function pjl(){
        PenjualanTable.style.display = 'block';
        PembelianTable.style.display = 'none';
        GrafikLaporan.style.display = 'none';
        $.get('{{ route('laporanPenjualan') }}', function (data) {
            templetPJL(data);
        });
    }

    function grafik(){
        PenjualanTable.style.display = 'none';
        PembelianTable.style.display = 'none';
        GrafikLaporan.style.display = 'block';
        $(document).ready(function() {
            TrsByYears();
            PieChartIncome();
            PieChartOutcome();
            IncomePrd_Jasa();
        });
    }

    function detailPJL(noPenjualan) {
        const encryptedId = btoa(noPenjualan);
        window.open("{{ route('detailLaporanPJL', '') }}/" + encryptedId, '_blank');
    }

    function detailPBL(noPembelian) {
        const encryptedId = btoa(noPembelian);
        window.open("{{ route('detailLaporanPBL', '') }}/" + encryptedId, '_blank');
    }

    function TrsByYears() {
        var years = $('#tahun').val();
        $.ajax({
            url: "{{route('TrsByYears')}}",
            method: "POST",
            data: {
                'tahun': years,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                const dataPJL = new Array(12).fill(0);
                const dataPBL = new Array(12).fill(0);

                data.pjl.forEach(val => {
                    dataPJL[val.month - 1] = val.Total;
                });

                data.pbl.forEach(val => {
                    dataPBL[val.month - 1] = val.Total;
                });
                LineChart(dataPJL, dataPBL);
            }
        });
    }

    function PieChartIncome() {
        var years = $('#tahun-income').val();
        $.ajax({
            url: "{{route('TrsByYears')}}",
            method: "POST",
            data: {
                'tahun': years,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                const dataPJL = new Array(12).fill(0);
                const dataPBL = new Array(12).fill(0);

                data.pjl.forEach(val => {
                    dataPJL[val.month - 1] = val.Total;
                });

                data.pbl.forEach(val => {
                    dataPBL[val.month - 1] = val.Total;
                });
                IncomePie(dataPJL);
            }
        });
    }

    function PieChartOutcome(){
        var years = $('#tahun-outcome').val();
        $.ajax({
            url: "{{route('TrsByYears')}}",
            method: "POST",
            data: {
                'tahun': years,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                const dataPJL = new Array(12).fill(0);
                const dataPBL = new Array(12).fill(0);

                data.pjl.forEach(val => {
                    dataPJL[val.month - 1] = val.Total;
                });

                data.pbl.forEach(val => {
                    dataPBL[val.month - 1] = val.Total;
                });
                OutcomePie(dataPBL);
            }
        });
    }

    function IncomePrd_Jasa() {
        var years = $("#tahun-prdjasa").val();
        var month = $("#bulan_PrdJasa").val();
        $.ajax({
            url: "{{route('incomePrdJasa')}}",
            method: "POST",
            data: {
                'tahun': years,
                'bulan': month,
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                const dataset = [data.prd, data.jas];
                ChartIncomePrd_Jasa(dataset);
            }
        });
    }

    function templetPJL(data){
        var laporanData = data.data;
        var html = '';
        var no = 1;

        if (Array.isArray(laporanData) && laporanData.length === 0) {
            html += '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        } else{
            $.each(laporanData, function (index, pjl) {
                html += '<tr>';
                html += '<th>' + no++ + '</th>';
                html += '<th style="width: 15%">' + pjl.no_penjualan + '</th>';
                html += '<th style="width: 20%">' + formatDate(new Date(pjl.created_at)) + '</th>';
                html += '<th style="width: 13%">' + pjl.nama_pegawai + '</th>';
                html += '<th style="width: 20%">' + pjl.telp_pelanggan + '</th>';
                html += '<th style="width: 20%">Rp ' + parseFloat(pjl.total_harga).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</th>';
                html += '<td style="width: 20%">';
                html += '<button class="btn btn-secondary text-white" onclick="detailPJL(\'' + pjl.no_penjualan + '\')">';
                html += '<i class="fa-solid fa-circle-info"></i> Detail';
                html += '</button>';
                html += '<a class="btn btn-danger text-white" target="_blank" href="{{ route('NotaPJL', '') }}/' + btoa(pjl.no_penjualan) + '">';
                html += '<i class="fa-solid fa-print"></i> Nota';
                html += '</a>';
                html += '</td>';
                html += '</tr>';
            });
        }
        

        $('#laporan_PJL').html(html);

        var htmlFilter = templetFilter(data);
        htmlFilter += '<div class="col-4">';
        htmlFilter += '<button onclick="filterPJL()" class="btn btn-primary">Filter</button>';
        htmlFilter += '</div>';
        $('#filterPJL').html(htmlFilter);
        
        var totalHarga = 0;

        $.each(laporanData, function (index, pjl) {
            totalHarga += parseFloat(pjl.total_harga);
        });
        
        var htmlTotal = '<th>Rp ' + totalHarga.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</th>';
        $('#total').html(htmlTotal);

    }

    function templetPBL(data){
        var laporanData = data.data;
        var html = '';
        var no = 1;

        if (Array.isArray(laporanData) && laporanData.length === 0) {
            html += '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        }else {
            $.each(laporanData, function (index, pbl) {
                html += '<tr>';
                html += '<th>' + no++ + '</th>';
                html += '<th style="width: 15%">' + pbl.no_pembelian + '</th>';
                html += '<th style="width: 20%">' + formatDate(new Date(pbl.created_at)) + '</th>';
                html += '<th style="width: 13%">' + pbl.nama_pegawai + '</th>';
                html += '<th style="width: 20%">' + pbl.keterangan + '</th>';
                html += '<th style="width: 20%">Rp ' + parseFloat(pbl.total_harga).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</th>';
                html += '<td style="width: 20%">';
                html += '<button class="btn btn-secondary text-white" onclick="detailPBL(\'' + pbl.no_pembelian + '\')">';
                html += '<i class="fa-solid fa-circle-info"></i> Detail';
                html += '</button>';
                html += '<a class="btn btn-danger text-white" target="_blank" href="{{ route('NotaPBL', '') }}/' + btoa(pbl.no_pembelian) + '">';
                html += '<i class="fa-solid fa-print"></i> Nota';
                html += '</a>';
                html += '</td>';
                html += '</tr>';
            });
        }

        $('#laporan_PBL').html(html);

        var htmlFilter = templetFilter(data);
        htmlFilter += '<div class="col-4">';
        htmlFilter += '<button onclick="filterPBL()" class="btn btn-primary">Filter</button>';
        htmlFilter += '</div>';
        $('#filterPBL').html(htmlFilter);
        
        var totalHarga = 0;

        $.each(laporanData, function (index, pbl) {
            totalHarga += parseFloat(pbl.total_harga);
        });
        
        var htmlTotal = '<th>Rp ' + totalHarga.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.') + '</th>';
        $('#total_pbl').html(htmlTotal);

    }

    function templetFilter(data){
        var laporanData = data.tanggal;
        var html = '';
        html += '<div class="col-4">';
        html += '<input type="date" class="form-control" name="tgl_awal" value="' + laporanData.tgl_awal + '" title="Tanggal Awal">';
        html += '</div>';
        html += '<div class="col-4">';
        html += '<input type="date" class="form-control" name="tgl_akhir" value="' + laporanData.tgl_akhir + '" title="Tanggal Akhir">';
        html += '</div>';
        return html;
    }

    function filterPJL(){
        var tgl_awal = $('input[name="tgl_awal"]').val();
        var tgl_akhir = $('input[name="tgl_akhir"]').val();
        $.ajax({
            url: "{{ route('filterPJL') }}",
            method: "POST",
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                templetPJL(data);
            }
        });
    }

    function filterPBL(){
        var tgl_awal = $('input[name="tgl_awal"]').val();
        var tgl_akhir = $('input[name="tgl_akhir"]').val();
        $.ajax({
            url: "{{ route('filterPBL') }}",
            method: "POST",
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                templetPBL(data);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        const searchPenjualan = document.getElementById("searchPenjualan");
        const tablePenjualan = document.getElementById("tableLaporan_PJL").getElementsByTagName("tbody")[0].rows;
        const searchPembelian = document.getElementById("searchPembelian");
        const tablePembelian = document.getElementById("tableLaporan_PBL").getElementsByTagName("tbody")[0].rows;
        
        searchPenjualan.addEventListener("input", function() {
            const searchValuePJL = searchPenjualan.value.toLowerCase();
            for (let i = 0; i < tablePenjualan.length; i++) {
                const rowData = tablePenjualan[i].innerText.toLowerCase();
                if (rowData.includes(searchValuePJL)) {
                    tablePenjualan[i].style.display = "";
                } else {
                    tablePenjualan[i].style.display = "none";
                }
            }
        });

        searchPembelian.addEventListener("input", function() {
            const searchValuePBL = searchPembelian.value.toLowerCase();
            for (let i = 0; i < tablePembelian.length; i++) {
                const rowData = tablePembelian[i].innerText.toLowerCase();
                if (rowData.includes(searchValuePBL)) {
                    tablePembelian[i].style.display = "";
                } else {
                    tablePembelian[i].style.display = "none";
                }
            }
        });
    });

    function formatDate(date) {
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        const day = days[date.getDay()];
        const dayOfMonth = date.getDate();
        const month = months[date.getMonth()];
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, "0");
        const minutes = date.getMinutes().toString().padStart(2, "0");
        const seconds = date.getSeconds().toString().padStart(2, "0");

        return `${day}, ${dayOfMonth} ${month} ${year}, ${hours}:${minutes}:${seconds}`;
    }

</script>

@endsection