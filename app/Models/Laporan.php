<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'kode',
        'jenis',
        'jenis_hewan',
        'detail_kejadian',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'nama_pelapor',
        'no_hp',
        'status',
        'catatan_admin',
        'id_kawasan',
        'id_kabupaten_kota',
        'id_admin',
        'ip_pelapor',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'detail_kejadian' => 'array',
        ];
    }

    public function kawasanHutan()
    {
        return $this->belongsTo(KawasanHutan::class, 'id_kawasan');
    }

    public function kabupatenKota()
    {
        return $this->belongsTo(KabupatenKota::class, 'id_kabupaten_kota');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }

    public function prediksiApi()
    {
        return $this->hasMany(PrediksiApi::class, 'id_laporan');
    }

    public function getDeskripsiTerstrukturAttribute(): array
    {
        $raw = trim((string) $this->deskripsi);
        if ($raw === '') {
            return [
                'is_structured' => false,
                'items' => [],
                'raw' => '',
            ];
        }

        $lines = preg_split('/\r\n|\r|\n/', $raw);
        $items = [];
        $kvCount = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if (preg_match('/^([^:\n]{2,35}):\s*(.*)$/u', $line, $m)) {
                $kvCount++;
                $items[] = [
                    'label' => trim($m[1]),
                    'value' => trim($m[2]),
                ];
            } else {
                if (count($items) > 0) {
                    $lastIndex = count($items) - 1;
                    $items[$lastIndex]['value'] .= "\n" . $line;
                } else {
                    $items[] = [
                        'label' => 'Keterangan',
                        'value' => $line,
                    ];
                }
            }
        }

        if ($kvCount === 0 && preg_match_all('/(?:^|(?<=\s))([A-Za-z0-9\s\/\-_()]{2,30}):\s*([^:]+?)(?=(?:[A-Za-z0-9\s\/\-_()]{2,30}:|$))/u', $raw, $matches, PREG_SET_ORDER)) {
            if (count($matches) >= 2) {
                $items = [];
                foreach ($matches as $m) {
                    $items[] = [
                        'label' => trim($m[1]),
                        'value' => trim($m[2]),
                    ];
                }
                return [
                    'is_structured' => true,
                    'items' => $items,
                    'raw' => $raw,
                ];
            }
        }

        if ($kvCount >= 1 && count($items) > 0) {
            return [
                'is_structured' => true,
                'items' => $items,
                'raw' => $raw,
            ];
        }

        return [
            'is_structured' => false,
            'items' => [],
            'raw' => $raw,
        ];
    }
}

