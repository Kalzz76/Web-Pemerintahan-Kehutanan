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
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'nama_pelapor',
        'no_hp',
        'status',
        'catatan_admin',
        'id_kawasan',
        'id_admin',
        'ip_pelapor',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function kawasanHutan()
    {
        return $this->belongsTo(KawasanHutan::class, 'id_kawasan');
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
