<?php

namespace Database\Seeders;

use App\Models\TitikPenting;
use App\Models\KawasanHutan;
use App\Models\KabupatenKota;
use Illuminate\Database\Seeder;

class TitikPentingSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama' => 'Pintu Masuk Cibodas (TNGGP)',
                'jenis' => 'Pos Jaga',
                'latitude' => -6.7460,
                'longitude' => 107.0050,
                'kabupaten' => 'Kabupaten Cianjur',
                'kawasan' => 'Taman Nasional Gunung Gede Pangrango',
                'deskripsi' => 'Pos jaga dan pintu masuk pendakian Cibodas jalur utama TNGGP.',
                'kontak' => '0263-512776',
            ],
            [
                'id' => 2,
                'nama' => 'Pintu Masuk Palutungan (TNGC)',
                'jenis' => 'Pos Jaga',
                'latitude' => -6.9300,
                'longitude' => 108.4350,
                'kabupaten' => 'Kabupaten Kuningan',
                'kawasan' => 'Taman Nasional Gunung Ciremai',
                'deskripsi' => 'Pos pantau kehutanan dan registrasi jalur pendakian Palutungan Ciremai.',
                'kontak' => '0232-8880860',
            ],
            [
                'id' => 3,
                'nama' => 'Pintu Masuk Camp David Papandayan',
                'jenis' => 'Pos Jaga',
                'latitude' => -7.3190,
                'longitude' => 107.7370,
                'kabupaten' => 'Kabupaten Garut',
                'kawasan' => 'Taman Wisata Alam Gunung Papandayan',
                'deskripsi' => 'Pos pengawasan gerbang utama kawasan wisata dan mitigasi erupsi/kebakaran Papandayan.',
                'kontak' => null,
            ],
            [
                'id' => 4,
                'nama' => 'Pintu Masuk Tangkuban Parahu',
                'jenis' => 'Pos Jaga',
                'latitude' => -6.7600,
                'longitude' => 107.6100,
                'kabupaten' => null,
                'kawasan' => 'Gunung Tangkubanparahu (CA dan TWA)',
                'deskripsi' => 'Gerbang pos pengamanan kawasan konservasi dan wisata kawah aktif.',
                'kontak' => null,
            ],
            [
                'id' => 5,
                'nama' => 'Permukiman Cibodas',
                'jenis' => 'Permukiman',
                'latitude' => -6.7400,
                'longitude' => 107.0000,
                'kabupaten' => 'Kabupaten Cianjur',
                'kawasan' => null,
                'deskripsi' => 'Area permukiman penduduk warga desa yang berbatasan langsung dengan kaki kawasan hutan TNGGP.',
                'kontak' => null,
            ],
            [
                'id' => 6,
                'nama' => 'Permukiman Palutungan',
                'jenis' => 'Permukiman',
                'latitude' => -6.9400,
                'longitude' => 108.4300,
                'kabupaten' => 'Kabupaten Kuningan',
                'kawasan' => null,
                'deskripsi' => 'Kawasan permukiman dan lahan perkebunan masyarakat lereng barat daya Ciremai.',
                'kontak' => null,
            ],
            [
                'id' => 7,
                'nama' => 'Permukiman Cisurupan',
                'jenis' => 'Permukiman',
                'latitude' => -7.3100,
                'longitude' => 107.7600,
                'kabupaten' => 'Kabupaten Garut',
                'kawasan' => null,
                'deskripsi' => 'Desa permukiman padat masyarakat petani lereng Gunung Papandayan.',
                'kontak' => null,
            ],
        ];

        TitikPenting::whereNotIn('id', range(1, 7))->delete();

        foreach ($data as $item) {
            $idKawasan = $item['kawasan'] ? KawasanHutan::where('nama', $item['kawasan'])->value('id') : null;
            $idKabupaten = $item['kabupaten'] ? KabupatenKota::where('nama', $item['kabupaten'])->value('id') : null;

            TitikPenting::updateOrCreate(
                ['id' => $item['id']],
                [
                    'nama' => $item['nama'],
                    'jenis' => $item['jenis'],
                    'latitude' => $item['latitude'],
                    'longitude' => $item['longitude'],
                    'deskripsi' => $item['deskripsi'],
                    'kontak' => $item['kontak'],
                    'id_kawasan' => $idKawasan,
                    'id_kabupaten_kota' => $idKabupaten,
                ]
            );
        }
    }
}
