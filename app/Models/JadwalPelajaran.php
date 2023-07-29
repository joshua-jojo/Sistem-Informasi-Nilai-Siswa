<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPelajaran extends Model
{
    use HasFactory,SoftDeletes;

    function user() {
        return $this->belongsTo(User::class);
    }

    function kelas() {
        return $this->belongsTo(Kelas::class);
    }

    function mata_pelajaran() {
        return $this->belongsTo(MataPelajaran::class);
    }

    function absensi() {
        return $this->hasMany(Absensi::class);
    }
    
    public function scopeFilterByDate($query, $fromDate, $toDate)
    {
        return $query->whereBetween('tanggal', [$fromDate, $toDate]);
    }
}
