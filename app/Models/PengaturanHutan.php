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
        'tampilkan_hiasan_sidebar',
        'lat_pusat',
        'long_pusat',
        'zoom_awal',
        'bbox_barat',
        'bbox_selatan',
        'bbox_timur',
        'bbox_utara',
        'terakhir_ambil_firms',
    ];

    protected function casts(): array
    {
        return [
            'tampilkan_hiasan_sidebar' => 'boolean',
            'lat_pusat' => 'float',
            'long_pusat' => 'float',
            'zoom_awal' => 'integer',
            'bbox_barat' => 'float',
            'bbox_selatan' => 'float',
            'bbox_timur' => 'float',
            'bbox_utara' => 'float',
            'terakhir_ambil_firms' => 'datetime',
        ];
    }
}
