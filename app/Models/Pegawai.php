<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pegawai';
    protected $guarded = ['no_pegawai', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user')->withTrashed();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role')->withTrashed();
    }
}
