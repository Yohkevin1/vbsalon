<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pembelian';
    protected $guarded = ['no_pembelian', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk')->withTrashed();
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'no_pegawai', 'no_pegawai')->withTrashed();
    }

    public function jmlhPBLByYears($years)
    {
        return DB::table('pembelian')
            ->selectRaw('MONTH(created_at) as month, SUM(total_harga) as Total')
            ->whereYear('created_at', $years)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();
    }
}
