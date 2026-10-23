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

    public function getLabelKepercayaanAttribute(): string
    {
        $val = strtolower(trim((string) $this->kepercayaan));
        if ($val === 'l' || $val === 'low') {
            return 'Keyakinan Rendah';
        }
        if ($val === 'n' || $val === 'nominal') {
            return 'Keyakinan Sedang (Nominal)';
        }
        if ($val === 'h' || $val === 'high') {
            return 'Keyakinan Tinggi';
        }
        if (is_numeric($val)) {
            return $val . '% Yakin';
        }
        return ucfirst($this->kepercayaan);
    }

    public function getWaktuDeteksiFormattedAttribute(): string
    {
        $raw = str_pad(trim((string) $this->waktu_deteksi), 4, '0', STR_PAD_LEFT);
        if (strlen($raw) === 4 && is_numeric($raw)) {
            $jam = (int) substr($raw, 0, 2);
            $menit = substr($raw, 2, 2);
            // Konversi dari UTC NASA FIRMS ke WIB (+7)
            $jamWib = ($jam + 7) % 24;
            return sprintf('%02d:%s WIB', $jamWib, $menit);
        }
        return (string) $this->waktu_deteksi;
    }
}

