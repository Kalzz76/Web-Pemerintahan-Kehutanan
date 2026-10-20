<?php

namespace Database\Seeders;

use App\Models\KontakDarurat;
use Illuminate\Database\Seeder;

class KontakDaruratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'urutan' => 1,
                'nama' => 'Layanan Darurat Terpadu',
                'instansi' => 'Layanan nasional',
                'nomor_telepon' => '112',
                'keterangan' => 'Layanan darurat untuk semua jenis kejadian',
            ],
            [
                'id' => 2,
                'urutan' => 2,
                'nama' => 'Pemadam Kebakaran',
                'instansi' => 'Dinas Pemadam Kebakaran',
                'nomor_telepon' => '113',
                'keterangan' => 'Untuk kebakaran',
            ],
            [
                'id' => 3,
                'urutan' => 3,
                'nama' => 'Polisi',
                'instansi' => 'Polri',
                'nomor_telepon' => '110',
                'keterangan' => 'Untuk gangguan keamanan',
            ],
            [
                'id' => 4,
                'urutan' => 4,
                'nama' => 'BPBD Provinsi Jawa Barat',
                'instansi' => 'BPBD',
                'nomor_telepon' => '(022) 7313231',
                'keterangan' => 'Penanggulangan bencana tingkat provinsi',
            ],
        ];

        KontakDarurat::whereNotIn('id', range(1, 4))->delete();

        foreach ($data as $item) {
            KontakDarurat::updateOrCreate(
                ['id' => $item['id']],
                [
                    'urutan' => $item['urutan'],
                    'nama' => $item['nama'],
                    'instansi' => $item['instansi'],
                    'nomor_telepon' => $item['nomor_telepon'],
                    'keterangan' => $item['keterangan'],
                ]
            );
        }
    }
}
