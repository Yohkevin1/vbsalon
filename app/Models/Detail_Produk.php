<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Produk extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'detail_produk';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'kode_produk', 'kode_produk')->withTrashed();
    }
}
