 @php
    $route= Route::current()->getName();
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class='bx bx-cut'></i>
        </div>
        <div class="sidebar-brand-text mx-3">VB Salon</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (session('role') != "pegawai")
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{$route=='dashboard' ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span>Dashboard</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Transaksi & Laporan
    </div>

    <!-- Nav Item - Pembayaran Collapse Menu -->
    <li class="nav-item {{$route=='transaksi'||$route=='storeTransaksi'||$route=="editPagePJL"||$route=="detailPJL"||$route=='pembelian'||$route=='storePembelian'||$route=="editPagePBL"||$route=="detailPBL" ? 'active' : ''}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Pembayaran"
            aria-expanded="true" aria-controls="Pembayaran">
            <i class="fas fa-wallet"></i>
            <span>Transaksi</span>
        </a>
        <div id="Pembayaran" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header ">Transaksi Pembayaran:</h6>
                <a class="collapse-item" href="{{ route('transaksi') }}">Penjualan</a>
                <a class="collapse-item" href="{{ route('pembelian') }}">Pembelian</a>
            </div>
        </div>
    </li>
    @if (session('role') != "pegawai")
        <!-- Nav Item - Charts -->
        <li class="nav-item {{$route=='laporan'? 'active' : ''}}">
            <a class="nav-link" href="{{ route('laporan') }}">
                <i class="fa-solid fa-book-open"></i>
                <span>Laporan</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            INTERNAL
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item {{$route=='pegawai'||$route=='pegawaiPage'||$route=="pegawaiEditPage"||$route=="detailPagePGW" ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('pegawai') }}">
                <i class="fas fa-users"></i>
                <span>Pegawai</span>
            </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item {{$route=='produk'||$route=='produkPage'||$route=="produkEditPage"||$route=="detailPage" ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('produk')}}">
                <i class="fas fa-warehouse"></i>
                <span>Produk</span>
            </a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{$route=='supplier'||$route=='supplierPage'||$route=="supplierEditPage"||$route=="detailPageSPL" ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('supplier') }}">
                <i class="fas fa-user-cog"></i>
                <span>Supplier</span>
            </a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item {{$route=='jasa'||$route=='jasaPage'||$route=="jasaEditPage"||$route=="detailPageJasa" ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('jasa') }}">
                <i class="fa-solid fa-scissors"></i>
                <span>Jasa</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->