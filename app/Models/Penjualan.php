<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Month;

class Penjualan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'penjualan';
    protected $guarded = ['no_penjualan', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'no_pegawai', 'no_pegawai')->withTrashed();
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk')->withTrashed();
    }

    function getReport($tgl1, $tgl2)
    {
        return DB::table('penjualan as p')
            ->join('detail_barang as db', 'p.no_penjualan', '=', 'db.no_penjualan')
            ->join('detail_jasa as dj', 'p.no_penjualan', '=', 'dj.no_penjualan')
            ->whereBetween('p.created_at', [$tgl1, $tgl2])
            ->select('p.*', 'db.*', 'dj.*')
            ->get();
    }

    public function jmlhPJLByYears($years)
    {
        return DB::table('penjualan')
            ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as Total')
            ->whereYear('created_at', $years)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();
    }

    public function incomeByProduk($years, $month)
    {
        return DB::table('penjualan as p')
            ->join('detail_produk as dp', 'p.no_penjualan', '=', 'dp.no_penjualan')
            ->selectRaw('SUM(dp.subtotal) as Total')
            ->whereYear('p.created_at', $years)
            ->whereMonth('p.created_at', $month)
            ->get();
    }

    public function incomeByJasa($years, $month)
    {
        return DB::table('penjualan as p')
            ->join('detail_jasa as dj', 'p.no_penjualan', '=', 'dj.no_penjualan')
            ->selectRaw('SUM(dj.subtotal) as Total')
            ->whereYear('p.created_at', $years)
            ->whereMonth('p.created_at', $month)
            ->get();
    }
}
