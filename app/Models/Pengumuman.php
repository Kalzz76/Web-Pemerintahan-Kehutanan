<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'gambar',
        'tanggal',
        'status',
        'id_user',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    protected $appends = ['gambar_url'];

    public function getGambarUrlAttribute(): ?string
    {
        if (empty($this->gambar)) {
            return null;
        }
        if (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://')) {
            return $this->gambar;
        }
        if (file_exists(public_path($this->gambar))) {
            return asset($this->gambar);
        }
        if (file_exists(public_path('storage/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
