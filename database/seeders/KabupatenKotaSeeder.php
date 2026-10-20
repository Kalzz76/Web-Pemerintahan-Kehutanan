<?php

namespace Database\Seeders;

use App\Models\KabupatenKota;
use Illuminate\Database\Seeder;

class KabupatenKotaSeeder extends Seeder
{
    public function run(): void
    {
        $kabupaten = [
            'Bandung',
            'Bandung Barat',
            'Bekasi',
            'Bogor',
            'Ciamis',
            'Cianjur',
            'Cirebon',
            'Garut',
            'Indramayu',
            'Karawang',
            'Kuningan',
            'Majalengka',
            'Pangandaran',
            'Purwakarta',
            'Subang',
            'Sukabumi',
            'Sumedang',
            'Tasikmalaya',
        ];

        foreach ($kabupaten as $nama) {
            KabupatenKota::updateOrCreate(
                ['nama' => 'Kabupaten ' . $nama],
                ['jenis' => 'Kabupaten']
            );
        }

        $kota = [
            'Bandung',
            'Banjar',
            'Bekasi',
            'Bogor',
            'Cimahi',
            'Cirebon',
            'Depok',
            'Sukabumi',
            'Tasikmalaya',
        ];

        foreach ($kota as $nama) {
            KabupatenKota::updateOrCreate(
                ['nama' => 'Kota ' . $nama],
                ['jenis' => 'Kota']
            );
        }
    }
}
