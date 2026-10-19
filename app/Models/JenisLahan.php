<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLahan extends Model
{
    use HasFactory;

    protected $table = 'jenis_lahan';

    protected $fillable = [
        'nama',
        'laju_dasar',
        'keterangan',
    ];

    public function kawasanHutan()
    {
        return $this->hasMany(KawasanHutan::class, 'id_jenis_lahan');
    }

    public function prediksiApi()
    {
        return $this->hasMany(PrediksiApi::class, 'id_jenis_lahan');
    }
}
