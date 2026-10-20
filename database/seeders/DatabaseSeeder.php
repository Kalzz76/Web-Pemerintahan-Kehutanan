<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PengaturanHutan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (User::count() === 0) {
            User::create([
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'status' => 'Aktif',
            ]);
        }

        PengaturanHutan::updateOrCreate(
            ['id' => 1],
            [
                'nama_aplikasi' => 'Jaga Hutan Jawa Barat',
                'nama_instansi' => 'Dinas Kehutanan Provinsi Jawa Barat',
                'slogan' => 'Bersama Menjaga Rimba dan Satwa Liar Jawa Barat',
                'deskripsi_singkat' => 'Sistem informasi pengelolaan kawasan hutan Provinsi Jawa Barat, pemantauan titik api, dan respon darurat konflik satwa liar.',
                'alamat' => 'Jl. Soekarno-Hatta No. 575, Kota Bandung, Jawa Barat',
                'email' => 'kehutanan@jabarprov.go.id',
                'telepon' => '(022) 7313231',
                'lat_pusat' => -6.87,
                'long_pusat' => 107.60,
                'zoom_awal' => 8,
                'bbox_barat' => 106.36,
                'bbox_selatan' => -7.83,
                'bbox_timur' => 108.85,
                'bbox_utara' => -5.90,
            ]
        );

        $this->call([
            KabupatenKotaSeeder::class,
            JenisLahanSeeder::class,
            KawasanHutanSeeder::class,
            PrimataSeeder::class,
            TumbuhanSeeder::class,
            TitikPentingSeeder::class,
            KontakDaruratSeeder::class,
            PengumumanSeeder::class,
        ]);
    }
}
