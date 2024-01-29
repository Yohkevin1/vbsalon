<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_Jasa extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'detail_jasa';

    public function jasa()
    {
        return $this->belongsTo(Jasa::class, 'id_jasa', 'id_jasa')->withTrashed();
    }
}


