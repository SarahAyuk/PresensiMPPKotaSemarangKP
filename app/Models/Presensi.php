<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "mpp_presensi";
    protected $fillable = [
        'id', 
        'petugas_id', 
        'instansi_id', 
        'tanggal', 
        'jam_masuk', 
        'jam_pulang', 
        'create_datetime', 
        'update_datetime', 
        'version'
    ];
}
