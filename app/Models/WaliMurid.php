<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaliMurid extends Model
{
    use HasFactory,SoftDeletes;

    function user(){
        return $this->hasOne(User::class);
    }

    function murid(){
        return $this->hasOne(User::class,'id','murid_id');
    }
}
