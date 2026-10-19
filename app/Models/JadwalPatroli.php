<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPatroli extends Model
{
    use HasFactory;

    protected $table = 'jadwal_patroli';

    protected $fillable = [
        'judul',
        'tanggal',
        'jam',
        'lokasi',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }
}
