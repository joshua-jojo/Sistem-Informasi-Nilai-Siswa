<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasUlangan extends Model
{
    use HasFactory;

    function kelas()
    {
        return $this->hasOne(Kelas::class, 'id', 'kelas_id');
    }

    function nilai()
    {
        return $this->hasMany(NilaiTugasUlangan::class,'tugas_ulangan_id');
    }
}
