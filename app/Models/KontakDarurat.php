<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KontakDarurat extends Model
{
    use HasFactory;

    protected $table = 'kontak_darurat';

    protected $fillable = [
        'nama',
        'instansi',
        'nomor_telepon',
        'keterangan',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
        ];
    }
}
