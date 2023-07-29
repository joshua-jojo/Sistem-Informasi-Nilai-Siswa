<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Murid extends Model
{
    use HasFactory, SoftDeletes;

    function agama() {
        return $this->belongsTo(Agama::class);
    }

    function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    function jurusan() {
        return $this->belongsTo(Jurusan::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}
