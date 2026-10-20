<?php

namespace Database\Seeders;

use App\Models\Primata;
use App\Models\KawasanHutan;
use Illuminate\Database\Seeder;

class PrimataSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'nama_lokal' => 'Owa Jawa',
                'nama_ilmiah' => 'Hylobates moloch',
                'status_konservasi' => 'EN',
                'dilindungi' => true,
                'habitat' => 'Hutan hujan dataran rendah sampai pegunungan, hidup di tajuk pohon.',
                'makanan' => 'Buah-buahan hutan, daun muda, dan bunga.',
                'ciri_khas' => 'Tidak berekor, lengan panjang, bulu abu-abu keperakan, hidup berpasangan setia dan bersuara nyaring.',
                'deskripsi' => 'Primata endemik Pulau Jawa yang hidup secara arboreal dan berstatus terancam punah.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Nasional Gunung Halimun-Salak',
                    'Cagar Alam Gunung Tilu',
                    'Cagar Alam Gunung Simpang',
                ],
            ],
            [
                'id' => 2,
                'nama_lokal' => 'Surili',
                'nama_ilmiah' => 'Presbytis comata',
                'status_konservasi' => 'EN',
                'dilindungi' => true,
                'habitat' => 'Hutan pegunungan (700 hingga 1.500 mdpl), beraktivitas di tajuk tengah sampai atas.',
                'makanan' => 'Daun muda, pucuk pohon, buah, dan bunga.',
                'ciri_khas' => 'Punggung abu-abu gelap, dada dan perut putih keabuan, terdapat jambul khas di kepala.',
                'deskripsi' => 'Satwa maskot Jawa Barat yang sangat peka terhadap fragmentasi dan alih fungsi habitat hutan.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Taman Nasional Gunung Halimun-Salak',
                    'Taman Nasional Gunung Ciremai',
                    'Cagar Alam Gunung Burangrang',
                    'Cagar Alam Gunung Tilu',
                    'Taman Wisata Alam Kawah Kamojang',
                    'Taman Wisata Alam Gunung Papandayan',
                    'Taman Wisata Alam Gunung Tampomas',
                ],
            ],
            [
                'id' => 3,
                'nama_lokal' => 'Lutung Jawa (Lutung Budeng)',
                'nama_ilmiah' => 'Trachypithecus auratus',
                'status_konservasi' => 'VU',
                'dilindungi' => true,
                'habitat' => 'Hutan primer dan sekunder, lereng gunung, hingga hutan pantai.',
                'makanan' => 'Daun muda, dedaunan hijau, dan buah-buahan.',
                'ciri_khas' => 'Bulu hitam keabu-abuan atau kecokelatan legam, anak yang baru lahir berwarna jingga terang.',
                'deskripsi' => 'Primata pemakan daun yang hidup berkelompok dan dilindungi oleh undang-undang konservasi.',
                'kawasan' => [
                    'Taman Nasional Gunung Gede Pangrango',
                    'Cagar Alam Gunung Tilu',
                    'Cagar Alam Gunung Burangrang',
                    'Pananjung Pangandaran (CA dan TWA)',
                ],
            ],
            [
                'id' => 4,
                'nama_lokal' => 'Kukang Jawa',
                'nama_ilmiah' => 'Nycticebus javanicus',
                'status_konservasi' => 'CR',
                'dilindungi' => true,
                'habitat' => 'Hutan primer, hutan sekunder, dan perkebunan rimbun dekat hutan.',
                'makanan' => 'Getah pohon, serangga malam, nektar, dan buah.',
                'ciri_khas' => 'Nokturnal, gerakan lambat hati-hati, mata bulat besar memantulkan cahaya, pola garis gelap di kepala.',
                'deskripsi' => 'Primata beracun nokturnal endemik Jawa yang berstatus kritis akibat perburuan dan perdagangan ilegal.',
                'kawasan' => [
                    'Taman Nasional Gunung Halimun-Salak',
                    'Taman Nasional Gunung Gede Pangrango',
                ],
            ],
            [
                'id' => 5,
                'nama_lokal' => 'Monyet Ekor Panjang',
                'nama_ilmiah' => 'Macaca fascicularis',
                'status_konservasi' => 'EN',
                'dilindungi' => false,
                'habitat' => 'Hutan pantai, hutan sekunder, hingga tepian kebun dekat permukiman masyarakat.',
                'makanan' => 'Buah-buahan, biji-bijian, serangga kecil, umbi, dan tanaman kebun.',
                'ciri_khas' => 'Ekor panjang sebanding dengan tubuh, bulu cokelat keabu-abuan, sangat adaptif dan hidup berkelompok besar.',
                'deskripsi' => 'Primata yang sering berinteraksi dan berkonflik dengan warga di pinggir kawasan hutan saat ketersediaan pakan alami menurun.',
                'kawasan' => [
                    'Pananjung Pangandaran (CA dan TWA)',
                    'Taman Wisata Alam Gunung Pancar',
                    'Taman Nasional Gunung Gede Pangrango',
                ],
            ],
        ];

        Primata::whereNotIn('id', [1, 2, 3, 4, 5])->delete();

        foreach ($data as $item) {
            $primata = Primata::updateOrCreate(
                ['id' => $item['id']],
                [
                    'nama_lokal' => $item['nama_lokal'],
                    'nama_ilmiah' => $item['nama_ilmiah'],
                    'status_konservasi' => $item['status_konservasi'],
                    'dilindungi' => $item['dilindungi'],
                    'habitat' => $item['habitat'],
                    'makanan' => $item['makanan'],
                    'ciri_khas' => $item['ciri_khas'],
                    'deskripsi' => $item['deskripsi'],
                ]
            );

            $idKawasan = KawasanHutan::whereIn('nama', $item['kawasan'])->pluck('id');
            $primata->kawasanHutan()->sync($idKawasan);
        }
    }
}
