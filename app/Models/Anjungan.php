<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anjungan extends Model
{
    use HasFactory;

    protected $table = 'mpp_data_anjungan';
    protected $fillable = [
        'id',
        'nama_anjungan',
        'id_klasifikasi_anjungan',
        'web_instansi',
        'alamat_email',
        'nomor_kontak',
        'is_aktif',
        'create_at',
        'modified_at',
        'modified_by'
        
    ];
}
