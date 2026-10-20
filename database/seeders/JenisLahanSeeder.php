<?php

namespace Database\Seeders;

use App\Models\JenisLahan;
use Illuminate\Database\Seeder;

class JenisLahanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Hutan Alam Pegunungan',
                'laju_dasar' => 150,
                'keterangan' => 'Hutan lebat taman nasional dan cagar alam, lembap',
            ],
            [
                'id' => 2,
                'nama' => 'Hutan Pinus Produksi',
                'laju_dasar' => 450,
                'keterangan' => 'Tegakan pinus, serasah kering mudah terbakar di musim kemarau',
            ],
            [
                'id' => 3,
                'nama' => 'Hutan Jati dan Mahoni',
                'laju_dasar' => 300,
                'keterangan' => 'Hutan produksi yang meranggas saat kemarau',
            ],
            [
                'id' => 4,
                'nama' => 'Padang Rumput dan Alang-alang',
                'laju_dasar' => 700,
                'keterangan' => 'Lahan terbuka berumput, api merambat paling cepat',
            ],
            [
                'id' => 5,
                'nama' => 'Semak Belukar',
                'laju_dasar' => 400,
                'keterangan' => 'Semak dan vegetasi rendah di lereng gunung',
            ],
            [
                'id' => 6,
                'nama' => 'Kebun Teh dan Perkebunan',
                'laju_dasar' => 200,
                'keterangan' => 'Kebun teh, karet, dan perkebunan lain',
            ],
            [
                'id' => 7,
                'nama' => 'Hutan Pantai dan Dataran Rendah',
                'laju_dasar' => 250,
                'keterangan' => 'Hutan di pesisir selatan dan dataran rendah',
            ],
            [
                'id' => 8,
                'nama' => 'Hutan Mangrove',
                'laju_dasar' => 100,
                'keterangan' => 'Hutan bakau pesisir, lembap dan berair',
            ],
        ];

        foreach ($data as $item) {
            JenisLahan::updateOrCreate(
                ['id' => $item['id']],
                [
                    'nama' => $item['nama'],
                    'laju_dasar' => $item['laju_dasar'],
                    'keterangan' => $item['keterangan'],
                ]
            );
        }
    }
}
