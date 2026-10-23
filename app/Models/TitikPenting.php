<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikPenting extends Model
{
    use HasFactory;

    protected $table = 'titik_penting';

    protected $fillable = [
        'nama',
        'jenis',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'kontak',
        'id_kawasan',
        'id_kabupaten_kota',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute(): ?string
    {
        if (empty($this->foto)) {
            return null;
        }
        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }
        if (file_exists(public_path($this->foto))) {
            return asset($this->foto);
        }
        if (file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    public function kawasanHutan()
    {
        return $this->belongsTo(KawasanHutan::class, 'id_kawasan');
    }

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'id_kabupaten_kota');
    }
}
