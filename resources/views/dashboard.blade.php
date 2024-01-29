@extends('layout.main')
@section('title')
VB Salon | Dashboard
@endsection
@section('judul')
Dashboard
@endsection
@section('content')
<!-- Content Row -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pengeluaran (Outcome)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="outcome">Loading .....</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-money-bill-transfer fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Penerimaan (Income)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="income">Loading ....</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-money-bill-trend-up fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Target Penjualan
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="progress">Loading...</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div id="progressbar" class="progress-bar bg-info" role="progressbar"
                                        aria-valuenow="0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-bullseye fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="jmlhPJL">Loding...</div>
                    </div>
                    <div class="col-auto">
                        <i class="fa-solid fa-receipt fa-2x text-black-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Grafik --}}
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Penerimaan & Pengeluaran</h6>
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
                        <select id="bulan_PrdJasa" class="form-control" onchange="IncomePrd_Jasa()">
                            <option value="1" disabled>Januari</option>
                            <option value="2" disabled>Februari</option>
                            <option value="3" disabled>Maret</option>
                            <option value="4" disabled>April</option>
                            <option value="5" disabled>Mei</option>
                            <option value="6" disabled>Juni</option>
                            <option value="7" disabled>Juli</option>
                            <option value="8" disabled>Agustus</option>
                            <option value="9" disabled>September</option>
                            <option value="10" disabled>Oktober</option>
                            <option value="11" disabled>November</option>
                            <option value="12" disabled>Desember</option>
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

<script>
    $(document).ready(function() {
        var now = new Date();
        var years = now.getFullYear();
        var month = new Date().getMonth() + 1;
        $("#bulan_PrdJasa").val(month);

        $.get('{{ route('outcome') }}', function(data) {
            $('#outcome').text(formatRupiah(data));
        });

        $.get('{{ route('income') }}', function(data) {
            $('#income').text(formatRupiah(data));
        });

        $.get('{{ route('jmlhPJL') }}', function(data) {
            var ariaValuMax = 50;
            var calculatedPercentage = (data / ariaValuMax) * 100;
            $('#progress').text(calculatedPercentage.toFixed(2) + '%');
            $('#progressbar').attr('aria-valuemax', ariaValuMax);
            $('#progressbar').css('width', calculatedPercentage + '%');
            $('#jmlhPJL').text(formatRibuan(data));
        });

        TrsByYears(years);
        IncomePrd_Jasa(years);
    });

    function formatRupiah(angka) {
        const reverse = angka.toString().split('').reverse().join('');
        const ribuan = reverse.match(/\d{1,3}/g);
        const formatted = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + formatted;
    }

    function formatRibuan(angka) {
        return angka.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    }

    function TrsByYears(years) {
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
                IncomePie(dataPJL);
                OutcomePie(dataPBL);
            }
        });
    }

    function IncomePrd_Jasa(years) {
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
</script>
@endsection