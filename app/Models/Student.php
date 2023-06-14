<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    // mendaftarkan fitur softdeletes
    use softDeletes;
    protected $fillable = [
        'nama',
        'nis',
        'rombel',
        'rayon',
    ];

    //nonaktif tmpestamps (created_at dan update_at) karena pada table yang dibaut tidak terdapat coloum tersebut
   // public $timestamps = false;
}
