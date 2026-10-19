<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanHutan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_hutan';

    protected $fillable = [
        'nama_aplikasi',
        'nama_instansi',
        'slogan',
        'deskripsi_singkat',
        'alamat',
        'email',
        'telepon',
        'logo',
        'lat_pusat',
        'long_pusat',
        'zoom_awal',
        'radius_titik_api_km',
        'terakhir_ambil_firms',
    ];

    protected function casts(): array
    {
        return [
            'lat_pusat' => 'float',
            'long_pusat' => 'float',
            'zoom_awal' => 'integer',
            'radius_titik_api_km' => 'integer',
            'terakhir_ambil_firms' => 'datetime',
        ];
    }
}
