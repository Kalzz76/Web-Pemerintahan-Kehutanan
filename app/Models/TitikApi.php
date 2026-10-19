<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikApi extends Model
{
    use HasFactory;

    protected $table = 'titik_api';

    protected $fillable = [
        'latitude',
        'longitude',
        'tanggal_deteksi',
        'waktu_deteksi',
        'kepercayaan',
        'sumber',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'tanggal_deteksi' => 'date',
        ];
    }
}
