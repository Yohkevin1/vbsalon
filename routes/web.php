<?php

use App\Http\Controllers\C_Auth;
use App\Http\Controllers\C_Dashboard;
use App\Http\Controllers\C_Home;
use App\Http\Controllers\C_Jasa;
use App\Http\Controllers\C_Laporan;
use App\Http\Controllers\C_Pegawai;
use App\Http\Controllers\C_Pembelian;
use App\Http\Controllers\C_Penjualan;
use App\Http\Controllers\C_Produk;
use App\Http\Controllers\C_Supplier;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/send-image/{id}', 'C_Penjualan@Nota');

Route::controller(C_Home::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/send-email', 'sendEmail')->name('sendEmail');
});

Route::controller(C_Auth::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
    Route::post('/resetPassAuth/{id}', 'resetPass')->name('resetPassAuth');
});

Route::middleware('login', 'owner')->controller(C_Dashboard::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/income', 'income')->name('income');
    Route::get('/outcome', 'outcome')->name('outcome');
    Route::get('/jmlhPJL', 'jmlhPJL')->name('jmlhPJL');
    Route::post('/TrsByYears', 'TrsByYears')->name('TrsByYears');
    Route::post('/incomePrdJasa', 'incomePrdJasa')->name('incomePrdJasa');
});

Route::middleware('login')->controller(C_Penjualan::class)->group(function () {
    Route::get('/transaksi', 'index')->name('transaksi');
    Route::get('/storetransaksi', 'storeTransaksi')->name('storeTransaksi');
    Route::post('/addCart', 'addToCart')->name('addCart');
    Route::get('/load', 'loadCart')->name('loadCart');
    Route::get('/loadDetail', 'loadCartDetail')->name('loadCartDetail');
    Route::get('/getTotal', 'getTotal')->name('getTotal');
    Route::delete('removeCart/{id}', 'removeCart')->name('removeCart');
    Route::post('/updateCart', 'updateCart')->name('updateCart');
    Route::post('/checkOut', 'pembayaran')->name('pembayaran');
    Route::get('/storetransaksi/{id}', 'editPagePJL')->name('editPagePJL');
    Route::post('/updatePembayaran', 'updatePembayaran')->name('updatePembayaran');
    Route::get('/detailTransaksi/{id}', 'detailPJL')->name('detailPJL');
});

Route::middleware('login')->controller(C_Pembelian::class)->group(function () {
    Route::get('/trsPembelian', 'index')->name('pembelian');
    Route::get('/storePembelian', 'storePembelian')->name('storePembelian');
    Route::post('/storePembelian', 'createPembelian')->name('storePembelian');
    Route::get('/storePembelian/{id}', 'editPagePBL')->name('editPagePBL');
    Route::post('/storePembelian/{id}', 'editPBL')->name('editPBL');
    Route::get('/detailPembelian/{id}', 'detailPBL')->name('detailPBL');
});

Route::middleware('owner')->controller(C_Laporan::class)->group(function () {
    Route::get('/laporan', 'index')->name('laporan');
    Route::get('/laporan/penjualan', 'penjualan')->name('laporanPenjualan');
    Route::get('/laporan/pembelian', 'pembelian')->name('laporanPembelian');
    Route::post('/laporan/filterPJL', 'filterPJL')->name('filterPJL');
    Route::post('/laporan/filterPBL', 'filterPBL')->name('filterPBL');
    Route::get('/laporan/penjualan/export', 'eksportPJL')->name('penjualanExport');
    Route::get('/laporan/pembelian/export', 'eksportPBL')->name('pembelianExport');
    Route::get('/detailLaporanPJL/{id}', 'detailPJL')->name('detailLaporanPJL');
    Route::get('/detailLaporanPBL/{id}', 'detailPBL')->name('detailLaporanPBL');
    Route::get('/notaPJL/{id}', 'NotaPJL')->name('NotaPJL');
    Route::get('/notaPBL/{id}', 'NotaPBL')->name('NotaPBL');
});

Route::middleware('owner')->controller(C_Pegawai::class)->group(function () {
    Route::get('/pegawai', 'index')->name('pegawai');
    Route::get('/pegawai/page', 'pegawaiPage')->name('pegawaiPage');
    Route::post('/pegawai/page/create', 'createPegawai')->name('createPegawai');
    Route::get('/pegawai/page/edit/{id}', 'pegawaiEditPage')->name('pegawaiEditPage');
    Route::post('/pegawai/page/edit/{id}', 'editPegawai')->name('editPegawai');
    Route::get('/pegawai/page/delete/{id}', 'deletePegawai')->name('deletePegawai');
    Route::post('/resetPass/{id}', 'resetPass')->name('resetPass');
    Route::get('/pegawai/page/{id}', 'detailPagePGW')->name('detailPagePGW');
});

Route::middleware('owner')->controller(C_Supplier::class)->group(function () {
    Route::get('/supplier', 'index')->name("supplier");
    Route::get("/supplier/page", "supplierPage")->name("supplierPage");
    Route::post('/supplier/page/create', 'createSupplier')->name('createSupplier');
    Route::get('/supplier/page/edit/{id}', 'supplierEditPage')->name('supplierEditPage');
    Route::post('/supplier/page/edit/{id}', 'editSupplier')->name('editSupplier');
    Route::get('/supplier/page/delete/{id}', 'deleteSupplier')->name('deleteSupplier');
    Route::get('/supplier/page/{id}', 'detailPageSPL')->name('detailPageSPL');
});

Route::middleware('owner')->controller(C_Jasa::class)->group(function () {
    Route::get('/jasa', 'index')->name("jasa");
    Route::get("/jasa/page", "jasaPage")->name("jasaPage");
    Route::post('/jasa/page/create', 'createJasa')->name('createJasa');
    Route::get('/jasa/page/edit/{id}', 'jasaEditPage')->name('jasaEditPage');
    Route::post('/jasa/page/edit/{id}', 'editJasa')->name('editJasa');
    Route::get('/jasa/page/delete/{id}', 'deleteJasa')->name('deleteJasa');
    Route::get('/jasa/page/{id}', 'detailPageJasa')->name('detailPageJasa');
});

Route::middleware('owner')->controller(C_Produk::class)->group(function () {
    Route::get('/produk', 'index')->name("produk");
    Route::get("/produk/page", "produkPage")->name("produkPage");
    Route::post('/produk/page/create', 'createProduk')->name('createProduk');
    Route::get('/produk/page/edit/{id}', 'produkEditPage')->name('produkEditPage');
    Route::post('/produk/page/edit/{id}', 'editProduk')->name('editProduk');
    Route::get('/produk/page/delete/{id}', 'deleteProduk')->name('deleteProduk');
    Route::get('/produk/page/{id}', 'detailPage')->name('detailPage');
});
