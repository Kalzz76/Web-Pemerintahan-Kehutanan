<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Primata extends Model
{
    use HasFactory;

    protected $table = 'primata';

    protected $fillable = [
        'nama_lokal',
        'nama_ilmiah',
        'status_konservasi',
        'dilindungi',
        'habitat',
        'makanan',
        'ciri_khas',
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
        return $this->belongsToMany(KawasanHutan::class, 'kawasan_primata', 'id_primata', 'id_kawasan');
    }
}
