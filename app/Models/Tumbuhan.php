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

    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }
        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://') || str_starts_with($this->foto, 'assets/') || str_starts_with($this->foto, 'images/')) {
            return asset($this->foto);
        }
        return asset('storage/' . $this->foto);
    }

    public function kawasanHutan()
    {
        return $this->belongsToMany(KawasanHutan::class, 'kawasan_tumbuhan', 'id_tumbuhan', 'id_kawasan');
    }
}
