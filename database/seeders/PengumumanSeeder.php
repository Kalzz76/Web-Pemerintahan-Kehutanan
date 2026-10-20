<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::value('id') ?? 1;

        $data = [
            [
                'id' => 1,
                'judul' => 'Cegah Kebakaran Hutan di Musim Kemarau',
                'kategori' => 'Tips Keselamatan',
                'isi' => 'Jangan membuang puntung rokok sembarangan dan jangan membakar sampah atau membersihkan lahan dekat kawasan hutan, terutama selama musim kemarau.',
                'gambar' => null,
                'tanggal' => Carbon::now()->toDateString(),
                'status' => 'Publish',
                'id_user' => $adminId,
            ],
            [
                'id' => 2,
                'judul' => 'Tindakan Tanggap Saat Melihat Api di Hutan',
                'kategori' => 'Tips Keselamatan',
                'isi' => 'Kalau melihat api di hutan: jauhi arah angin, jangan memadamkan sendiri kalau api sudah membesar, segera laporkan lewat aplikasi ini, dan hubungi kontak darurat 112 atau 113.',
                'gambar' => null,
                'tanggal' => Carbon::now()->subDays(1)->toDateString(),
                'status' => 'Publish',
                'id_user' => $adminId,
            ],
            [
                'id' => 3,
                'judul' => 'Panduan Menghadapi Satwa Liar Masuk Kampung',
                'kategori' => 'Tips Keselamatan',
                'isi' => 'Bertemu satwa liar di kebun atau perkampungan: tetap tenang, jaga jarak aman, jangan memberi makan atau menjerat satwa, dan segera laporkan lewat fitur Lapor Hewan Masuk Kampung.',
                'gambar' => null,
                'tanggal' => Carbon::now()->subDays(2)->toDateString(),
                'status' => 'Publish',
                'id_user' => $adminId,
            ],
        ];

        Pengumuman::whereNotIn('id', range(1, 3))->delete();

        foreach ($data as $item) {
            Pengumuman::updateOrCreate(
                ['id' => $item['id']],
                [
                    'judul' => $item['judul'],
                    'kategori' => $item['kategori'],
                    'isi' => $item['isi'],
                    'gambar' => $item['gambar'],
                    'tanggal' => $item['tanggal'],
                    'status' => $item['status'],
                    'id_user' => $item['id_user'],
                ]
            );
        }
    }
}
