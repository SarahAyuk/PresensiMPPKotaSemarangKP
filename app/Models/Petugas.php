<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'mpp_petugas';
    protected $fillable = [
        'id',
        'petugas_name', 
        'phone', 
        'anjungan_id',
        'active',
        'create_datetime',
        'update_datetime',
        'version'
    ];
}
