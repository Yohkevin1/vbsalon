<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jasa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'jasa';
    protected $guarded = ['id_jasa', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}
