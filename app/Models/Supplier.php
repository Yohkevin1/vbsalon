<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['kode_supplier', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}
