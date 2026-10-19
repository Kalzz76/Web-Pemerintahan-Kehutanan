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
}
