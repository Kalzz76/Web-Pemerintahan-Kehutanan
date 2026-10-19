<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tumbuhan extends Model
{
    use HasFactory;

    protected $table = 'tumbuhan';

    protected $fillable = [
        'nama_lokal',
        'nama_ilmiah',
        'jenis',
        'status_konservasi',
        'dilindungi',
        'manfaat',
        'deskripsi',
        'foto',
    ];

    protected function casts(): array
    {
        return [
            'dilindungi' => 'boolean',
        ];
    }

    public function kawasanHutan()
    {
        return $this->belongsToMany(KawasanHutan::class, 'kawasan_tumbuhan', 'id_tumbuhan', 'id_kawasan');
    }
}
