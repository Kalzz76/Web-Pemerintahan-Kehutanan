<?php

namespace Database\Seeders;

use App\Models\Tumbuhan;
use App\Models\KawasanHutan;
use Illuminate\Database\Seeder;

class TumbuhanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_lokal' => 'Rasamala',
                'nama_ilmiah' => 'Altingia excelsa',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Penyusun utama kanopi hutan pegunungan, penghasil kayu bernilai tinggi, dan penahan erosi lereng.',
                'deskripsi' => 'Pohon raksasa hutan hujan pegunungan tropis Jawa Barat yang batangnya dapat tumbuh tinggi menjulang hingga lebih dari 40 meter.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Nasional Gunung Halimun-Salak',
                ],
            ],
            [
                'id' => 2,
                'nama_lokal' => 'Puspa',
                'nama_ilmiah' => 'Schima wallichii',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Kayu pertukangan kuat, penahan angin, dan pengikat air tanah di kawasan lereng perbukitan.',
                'deskripsi' => 'Pohon dominan di kawasan hutan pegunungan bawah sampai atas dengan bunga putih beraroma lembut.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Nasional Gunung Halimun-Salak',
                    'Taman Nasional Gunung Ciremai',
                ],
            ],
            [
                'id' => 3,
                'nama_lokal' => 'Edelweis Jawa',
                'nama_ilmiah' => 'Anaphalis javanica',
                'jenis' => 'Perdu',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Tumbuhan pelopor penyubur tanah vulkanik pegunungan dan daya tarik keindahan ekosistem montana.',
                'deskripsi' => 'Tumbuhan perdu endemik zona pegunungan tinggi di atas 2.000 mdpl yang tidak boleh dipetik dan dilindungi oleh etika konservasi pendakian.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Wisata Alam Gunung Papandayan',
                    'Taman Nasional Gunung Ciremai',
                ],
            ],
            [
                'id' => 4,
                'nama_lokal' => 'Kantong Semar',
                'nama_ilmiah' => 'Nepenthes spp.',
                'jenis' => 'Lainnya',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Pengendali biologis serangga dan indikator kelembapan serta kesehatan ekosistem hutan.',
                'deskripsi' => 'Tumbuhan pemakan serangga unik dengan sulur membentuk kantong penangkap mangsa di kawasan berkabut.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                ],
            ],
            [
                'id' => 5,
                'nama_lokal' => 'Saninten',
                'nama_ilmiah' => 'Castanopsis argentea',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Biji dapat dimakan sebagai pangan lokal hutan dan kayunya dimanfaatkan untuk konstruksi bangunan.',
                'deskripsi' => 'Pohon hutan pegunungan tropis penghasil buah berduri khas menyerupai kastanye lokal.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Nasional Gunung Halimun-Salak',
                ],
            ],
            [
                'id' => 6,
                'nama_lokal' => 'Jamuju',
                'nama_ilmiah' => 'Dacrycarpus imbricatus',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Kayu lunak berkualitas, pohon peneduh hutan dataran tinggi, dan pelindung resapan air.',
                'deskripsi' => 'Spesies conifer pegunungan khas Malesia dengan susunan daun jarum halus yang rapat.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                ],
            ],
            [
                'id' => 7,
                'nama_lokal' => 'Anggrek Hutan',
                'nama_ilmiah' => 'Orchidaceae',
                'jenis' => 'Herba',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Plasma nutfah flora hias tropis dan indikator kelembapan serta tutupan hutan primer.',
                'deskripsi' => 'Kelompok herba epifit dengan variasi bunga khas yang menempel pada batang pohon-pohon besar hutan lebat.',
                'kawasan' => [
                    'Cagar Alam Gunung Tilu',
                    'Taman Nasional Gunung Gede Pangrango',
                ],
            ],
            [
                'id' => 8,
                'nama_lokal' => 'Rafflesia',
                'nama_ilmiah' => 'Rafflesia spp.',
                'jenis' => 'Lainnya',
                'status_konservasi' => 'NE',
                'dilindungi' => true,
                'manfaat' => 'Spesies kunci penarik penyerbuk hutan dan nilai penting keanekaragaman hayati dunia.',
                'deskripsi' => 'Bunga parasit langka tanpa daun dan batang sejati yang hidup menumpang pada liana Tetrastigma dan dilindungi ketat oleh peraturan negara.',
                'kawasan' => [
                    'Cagar Alam Gunung Tilu',
                    'Cagar Alam Gunung Simpang',
                ],
            ],
            [
                'id' => 9,
                'nama_lokal' => 'Pinus (Tusam)',
                'nama_ilmiah' => 'Pinus merkusii',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Penghasil getah gondorukem dan terpentin, reboisasi lahan kritis, serta obyek wisata hutan.',
                'deskripsi' => 'Pohon jarum yang banyak ditanam di hutan produksi dataran tinggi dengan serasah kering yang sangat mudah terbakar di musim kemarau.',
                'kawasan' => [
                    'Taman Wisata Alam Gunung Pancar',
                    'Taman Hutan Raya Ir. H. Djuanda',
                ],
            ],
            [
                'id' => 10,
                'nama_lokal' => 'Bakau',
                'nama_ilmiah' => 'Rhizophora spp.',
                'jenis' => 'Pohon',
                'status_konservasi' => 'NE',
                'dilindungi' => false,
                'manfaat' => 'Penahan abrasi ombak laut pantai selatan, penyaring sedimen, dan habitat pemijahan biota pesisir.',
                'deskripsi' => 'Pohon khas ekosistem muara dan mangrove pesisir pantai selatan Jawa Barat dengan akar tunjang kokoh.',
                'kawasan' => [
                    'Cagar Alam Leuweung Sancang',
                ],
            ],
        ];

        Tumbuhan::whereNotIn('id', range(1, 10))->delete();

        foreach ($data as $item) {
            $tumbuhan = Tumbuhan::updateOrCreate(
                ['id' => $item['id']],
                [
                    'nama_lokal' => $item['nama_lokal'],
                    'nama_ilmiah' => $item['nama_ilmiah'],
                    'jenis' => $item['jenis'],
                    'status_konservasi' => $item['status_konservasi'],
                    'dilindungi' => $item['dilindungi'],
                    'manfaat' => $item['manfaat'],
                    'deskripsi' => $item['deskripsi'],
                ]
            );

            $idKawasan = KawasanHutan::whereIn('nama', $item['kawasan'])->pluck('id');
            $tumbuhan->kawasanHutan()->sync($idKawasan);
        }
    }
}
