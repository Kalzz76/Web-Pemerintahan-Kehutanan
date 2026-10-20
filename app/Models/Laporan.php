<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'kode',
        'jenis',
        'jenis_hewan',
        'detail_kejadian',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'nama_pelapor',
        'no_hp',
        'status',
        'catatan_admin',
        'id_kawasan',
        'id_kabupaten_kota',
        'id_admin',
        'ip_pelapor',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'detail_kejadian' => 'array',
        ];
    }

    public function kawasanHutan()
    {
        return $this->belongsTo(KawasanHutan::class, 'id_kawasan');
    }

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'id_kabupaten_kota');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function prediksiApi()
    {
        return $this->hasMany(PrediksiApi::class, 'id_laporan');
    }
}
