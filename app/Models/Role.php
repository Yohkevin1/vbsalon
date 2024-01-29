<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes; // Aktifkan SoftDeletes trait
    protected $guarded = ['id_role', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];
}
