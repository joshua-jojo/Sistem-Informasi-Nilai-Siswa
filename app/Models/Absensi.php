<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use HasFactory,SoftDeletes;

    function user() {
        return $this->belongsTo(User::class);
    }

    function jadwal_pelajaran() {
        return $this->belongsTo(JadwalPelajaran::class);
    }

}
