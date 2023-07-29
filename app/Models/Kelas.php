<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    function murid()
    {
        return $this->hasMany(Murid::class,'kelas_id','id');
    }

}
