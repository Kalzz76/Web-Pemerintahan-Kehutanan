<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\PengaturanHutan;
use App\Models\JenisLahan;
use App\Models\KawasanHutan;
use App\Models\TitikPenting;
use App\Models\Primata;
use App\Models\Tumbuhan;
use App\Models\Pengumuman;
use App\Models\JadwalPatroli;
use App\Models\KontakDarurat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'status' => 'Aktif',
        ]);

        PengaturanHutan::create([
            'nama_aplikasi' => 'Jaga Hutan Desa',
            'nama_instansi' => 'Pemerintah Desa Hutan Lestari',
            'slogan' => 'Bersama Menjaga Rimba, Demi Kelestarian Desa',
            'deskripsi_singkat' => 'Sistem informasi pengelolaan, pemantauan kawasan hutan desa, respon cepat tanggap darurat kebakaran dan konflik satwa liar.',
            'alamat' => 'Jl. Raya Konservasi No. 1, Desa Hutan Lestari',
            'email' => 'jagahutan@desahutanlestari.id',
            'telepon' => '081234567890',
            'logo' => null,
            'lat_pusat' => -6.8921000,
            'long_pusat' => 108.4112000,
            'zoom_awal' => 13,
            'radius_titik_api_km' => 30,
            'terakhir_ambil_firms' => null,
        ]);

        $lahanHutanLebat = JenisLahan::create([
            'nama' => 'Hutan Lebat',
            'laju_dasar' => 150,
            'keterangan' => 'Hutan dengan kanopi rapat dan kelembapan lantai hutan tinggi.',
        ]);

        $lahanSemak = JenisLahan::create([
            'nama' => 'Semak Belukar',
            'laju_dasar' => 400,
            'keterangan' => 'Vegetasi semak campuran dengan potensi perambatan api sedang.',
        ]);

        JenisLahan::create([
            'nama' => 'Alang-alang/Padang Rumput',
            'laju_dasar' => 700,
            'keterangan' => 'Vegetasi kering mudah terbakar dengan perambatan sangat cepat.',
        ]);

        $lahanKebun = JenisLahan::create([
            'nama' => 'Kebun',
            'laju_dasar' => 250,
            'keterangan' => 'Area perkebunan produktif masyarakat di pinggiran hutan.',
        ]);

        JenisLahan::create([
            'nama' => 'Lahan Gambut',
            'laju_dasar' => 200,
            'keterangan' => 'Lahan dengan lapisan gambut organik tebal dan potensi api bawah tanah.',
        ]);

        $geojson1 = json_encode([
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [108.4050, -6.8850],
                        [108.4200, -6.8850],
                        [108.4220, -6.8950],
                        [108.4080, -6.8960],
                        [108.4050, -6.8850],
                    ],
                ],
            ],
        ]);

        $geojson2 = json_encode([
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [108.3980, -6.8970],
                        [108.4100, -6.8970],
                        [108.4120, -6.9050],
                        [108.4000, -6.9060],
                        [108.3980, -6.8970],
                    ],
                ],
            ],
        ]);

        $geojson3 = json_encode([
            'type' => 'Feature',
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [
                    [
                        [108.4150, -6.8970],
                        [108.4280, -6.8970],
                        [108.4270, -6.9070],
                        [108.4140, -6.9060],
                        [108.4150, -6.8970],
                    ],
                ],
            ],
        ]);

        $kawasan1 = KawasanHutan::create([
            'nama' => 'Kawasan Lindung Rimba Pinus',
            'deskripsi' => 'Kawasan inti hutan lindung bagian utara, habitat utama primata dan sumber mata air desa.',
            'luas_ha' => 245.50,
            'geojson' => $geojson1,
            'id_jenis_lahan' => $lahanHutanLebat->id,
        ]);

        $kawasan2 = KawasanHutan::create([
            'nama' => 'Blok Budidaya Lembah Hijau',
            'deskripsi' => 'Area agroforestri dan perkebunan rakyat yang membatasi hutan dengan pemukiman.',
            'luas_ha' => 118.25,
            'geojson' => $geojson2,
            'id_jenis_lahan' => $lahanKebun->id,
        ]);

        $kawasan3 = KawasanHutan::create([
            'nama' => 'Kawasan Semak Lereng Savana',
            'deskripsi' => 'Lereng terbuka bervegetasi semak kering yang berdekatan dengan jalur angin kencang.',
            'luas_ha' => 84.70,
            'geojson' => $geojson3,
            'id_jenis_lahan' => $lahanSemak->id,
        ]);

        TitikPenting::create([
            'nama' => 'Dusun Sukamaju',
            'jenis' => 'Permukiman',
            'latitude' => -6.9015000,
            'longitude' => 108.4110000,
            'deskripsi' => 'Pemukiman warga RT 01-04 dekat perbatasan hutan sisi timur.',
            'foto' => null,
            'kontak' => 'Kepala Dusun: 081234567893',
            'id_kawasan' => $kawasan2->id,
        ]);

        TitikPenting::create([
            'nama' => 'Dusun Wanareja',
            'jenis' => 'Permukiman',
            'latitude' => -6.9040000,
            'longitude' => 108.3960000,
            'deskripsi' => 'Pemukiman warga di tepi lereng perbukitan barat daya.',
            'foto' => null,
            'kontak' => 'Kepala Dusun: 081234567894',
            'id_kawasan' => $kawasan2->id,
        ]);

        TitikPenting::create([
            'nama' => 'Pos Jaga Pintu Rimba',
            'jenis' => 'Pos Jaga',
            'latitude' => -6.8900000,
            'longitude' => 108.4060000,
            'deskripsi' => 'Pos pantau utama petugas patroli hutan di gerbang barat.',
            'foto' => null,
            'kontak' => '081234567891',
            'id_kawasan' => $kawasan1->id,
        ]);

        TitikPenting::create([
            'nama' => 'Posko Pemadam Titik A',
            'jenis' => 'Pos Pemadam',
            'latitude' => -6.8980000,
            'longitude' => 108.4080000,
            'deskripsi' => 'Posko siaga karhutla dilengkapi tangki pompa jinjing dan selang darurat.',
            'foto' => null,
            'kontak' => '081234567892',
            'id_kawasan' => $kawasan2->id,
        ]);

        TitikPenting::create([
            'nama' => 'Embung Mata Air Cikawung',
            'jenis' => 'Sumber Air',
            'latitude' => -6.8880000,
            'longitude' => 108.4150000,
            'deskripsi' => 'Embung penampung air alami debit stabil untuk pemadaman helikopter atau pompa warga.',
            'foto' => null,
            'kontak' => null,
            'id_kawasan' => $kawasan1->id,
        ]);

        TitikPenting::create([
            'nama' => 'Lapangan Evakuasi Balai Desa',
            'jenis' => 'Titik Kumpul Evakuasi',
            'latitude' => -6.9025000,
            'longitude' => 108.4050000,
            'deskripsi' => 'Lokasi terbuka aman bebas jangkauan pohon tumbang dan api.',
            'foto' => null,
            'kontak' => '081234567890',
            'id_kawasan' => null,
        ]);

        $primata1 = Primata::create([
            'nama_lokal' => 'Owa Jawa',
            'nama_ilmiah' => 'Hylobates moloch',
            'status_konservasi' => 'EN',
            'dilindungi' => true,
            'habitat' => 'Tajuk pohon hutan primer dataran tinggi kanopi rapat.',
            'makanan' => 'Buah-buahan hutan, pucuk daun muda, dan nektar bunga.',
            'ciri_khas' => 'Bulu abu-abu keperakan, wajah hitam berbingkai putih, suara panggilan melodius di fajar hari.',
            'deskripsi' => 'Primata tanpa ekor yang bergerak lincah dengan cara berayun dari dahan ke dahan (brakhiasi). Memiliki kesetiaan tinggi pada pasangan.',
            'foto' => null,
        ]);

        $primata2 = Primata::create([
            'nama_lokal' => 'Lutung Jawa',
            'nama_ilmiah' => 'Trachypithecus auratus',
            'status_konservasi' => 'VU',
            'dilindungi' => true,
            'habitat' => 'Hutan primer dan sekunder lembap serta perbukitan.',
            'makanan' => 'Dedaunan muda, bunga, tunas, dan biji pohon hutan.',
            'ciri_khas' => 'Warna rambut hitam berkilau dengan ekor panjang, anakan berwarna oranye keemasan menyala.',
            'deskripsi' => 'Hidup dalam kelompok sosial terstruktur dipimpin pejantan dominan. Berperan penting menyebarkan biji flora hutan.',
            'foto' => null,
        ]);

        $primata3 = Primata::create([
            'nama_lokal' => 'Kukang Jawa',
            'nama_ilmiah' => 'Nycticebus javanicus',
            'status_konservasi' => 'CR',
            'dilindungi' => true,
            'habitat' => 'Rumpun bambu dan kanopi pohon sedang yang rimbun.',
            'makanan' => 'Getah pohon, nektar bunga, serangga, dan buah-buahan lunak.',
            'ciri_khas' => 'Mata besar bulat menghadap ke depan, gerakan sangat pelan dan berhati-hati, nokturnal.',
            'deskripsi' => 'Satu-satunya primata berbisa di dunia yang aktif berburu di malam hari. Populasinya sangat terancam kepunahan.',
            'foto' => null,
        ]);

        $primata4 = Primata::create([
            'nama_lokal' => 'Monyet Ekor Panjang',
            'nama_ilmiah' => 'Macaca fascicularis',
            'status_konservasi' => 'EN',
            'dilindungi' => false,
            'habitat' => 'Pinggiran hutan, tepian sungai, dan perbatasan kebun warga.',
            'makanan' => 'Segala jenis makanan (omnivora), buah, biji, umbi, dan serangga.',
            'ciri_khas' => 'Ekor panjang sebanding panjang tubuhnya, adaptif dan berani berinteraksi di sekitar pemukiman.',
            'deskripsi' => 'Sering turun mencari makan ke perkebunan warga saat musim kemarau panjang ketika ketersediaan pakan di hutan menipis.',
            'foto' => null,
        ]);

        $primata1->kawasanHutan()->attach([$kawasan1->id]);
        $primata2->kawasanHutan()->attach([$kawasan1->id, $kawasan2->id]);
        $primata3->kawasanHutan()->attach([$kawasan1->id]);
        $primata4->kawasanHutan()->attach([$kawasan2->id, $kawasan3->id]);

        $tumbuhan1 = Tumbuhan::create([
            'nama_lokal' => 'Pohon Damar',
            'nama_ilmiah' => 'Agathis dammara',
            'jenis' => 'Pohon',
            'status_konservasi' => 'VU',
            'dilindungi' => true,
            'manfaat' => 'Penyerap air tanah tinggi, penahan erosi lereng, dan resin getah bernilai tinggi.',
            'deskripsi' => 'Pohon konifer berukuran raksasa yang batangnya lurus menjulang tinggi mencapai 60 meter.',
            'foto' => null,
        ]);

        $tumbuhan2 = Tumbuhan::create([
            'nama_lokal' => 'Pohon Rasamala',
            'nama_ilmiah' => 'Altingia excelsa',
            'jenis' => 'Pohon',
            'status_konservasi' => 'LC',
            'dilindungi' => true,
            'manfaat' => 'Kayu awet pengatur tata air dan penghasil getah beraroma wangi.',
            'deskripsi' => 'Pohon endemik hutan pegunungan yang mengeluarkan aroma harum menyegarkan dari dedaunan dan kulit batangnya.',
            'foto' => null,
        ]);

        $tumbuhan3 = Tumbuhan::create([
            'nama_lokal' => 'Anggrek Kantung Jawa',
            'nama_ilmiah' => 'Paphiopedilum javanicum',
            'jenis' => 'Herba',
            'status_konservasi' => 'EN',
            'dilindungi' => true,
            'manfaat' => 'Indikator kebersihan lantai hutan dan keanekaragaman flora langka.',
            'deskripsi' => 'Anggrek tanah dengan kelopak menyerupai kantung unik berwana hijau bercak ungu eksotis.',
            'foto' => null,
        ]);

        $tumbuhan4 = Tumbuhan::create([
            'nama_lokal' => 'Rotan Jernang',
            'nama_ilmiah' => 'Daemonorops draco',
            'jenis' => 'Liana',
            'status_konservasi' => 'VU',
            'dilindungi' => true,
            'manfaat' => 'Bahan obat tradisional dari resin merah dan bahan kerajinan anyaman.',
            'deskripsi' => 'Tumbuhan merambat berduri di tajuk pohon kanopi lebat yang memproduksi resin merah darah bernilai tinggi.',
            'foto' => null,
        ]);

        $tumbuhan1->kawasanHutan()->attach([$kawasan1->id]);
        $tumbuhan2->kawasanHutan()->attach([$kawasan1->id]);
        $tumbuhan3->kawasanHutan()->attach([$kawasan1->id]);
        $tumbuhan4->kawasanHutan()->attach([$kawasan1->id, $kawasan2->id]);

        Pengumuman::create([
            'judul' => 'Himbauan Waspada Karhutla dan Larangan Pembakaran Lahan',
            'kategori' => 'Tips Keselamatan',
            'isi' => 'Mengingat tingginya potensi kekeringan selama puncak musim kemarau, warga desa diimbau untuk tidak membuka atau membersihkan lahan pertanian dengan membakar rumput. Jika melihat titik api atau kepulan asap di lereng hutan, segera laporkan lewat tombol Lapor Darurat.',
            'gambar' => null,
            'tanggal' => Carbon::now()->toDateString(),
            'status' => 'Publish',
            'id_user' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Patroli Bersama Satgas Desa dan Pembaruan Patok Kawasan Hutan',
            'kategori' => 'Kabar',
            'isi' => 'Satgas Jaga Hutan Desa bersama perwakilan BKSDA dan warga berhasil melaksanakan giat patroli menyusuri batas Blok Rimba Pinus. Seluruh patok penanda zona lindung telah diperbaiki dan diberi cat pemantul cahaya.',
            'gambar' => null,
            'tanggal' => Carbon::now()->subDays(2)->toDateString(),
            'status' => 'Publish',
            'id_user' => $admin->id,
        ]);

        Pengumuman::create([
            'judul' => 'Prosedur Aman Bila Hewan Liar dan Primata Memasuki Perkebunan',
            'kategori' => 'Pengumuman',
            'isi' => 'Apabila menjumpai kawanan kera atau satwa hutan lainnya turun ke kebun, jangan melakukan tindakan kekerasan seperti melempar batu tajam atau memasang racun berbahaya. Bunyikan kentongan atau kaleng untuk menghalau secara aman, lalu kirimkan laporan darurat agar petugas dapat melakukan koordinasi.',
            'gambar' => null,
            'tanggal' => Carbon::now()->subDays(5)->toDateString(),
            'status' => 'Publish',
            'id_user' => $admin->id,
        ]);

        JadwalPatroli::create([
            'judul' => 'Patroli Terpadu Titik Rawan Kebakaran Sektor Timur',
            'tanggal' => Carbon::now()->addDays(2)->toDateString(),
            'jam' => '08:30 - 12:00 WIB',
            'lokasi' => 'Blok Budidaya Lembah Hijau & Sekitar Dusun Sukamaju',
            'keterangan' => 'Pemeriksaan debit embung air dan jalur sekat bakar penahan api.',
        ]);

        JadwalPatroli::create([
            'judul' => 'Ronda Malam Pemantauan Satwa Liar',
            'tanggal' => Carbon::now()->addDays(4)->toDateString(),
            'jam' => '19:30 - 23:00 WIB',
            'lokasi' => 'Batas Hutan Dusun Wanareja',
            'keterangan' => 'Pengawasan pergerakan satwa nokturnal dan pencegahan perburuan liar.',
        ]);

        KontakDarurat::create([
            'nama' => 'Posko Damkar Sektor Hutan',
            'instansi' => 'Dinas Pemadam Kebakaran',
            'nomor_telepon' => '113',
            'keterangan' => 'Layanan darurat kebakaran 24 jam bebas pulsa',
            'urutan' => 1,
        ]);

        KontakDarurat::create([
            'nama' => 'Call Center BKSDA',
            'instansi' => 'Balai Konservasi Sumber Daya Alam',
            'nomor_telepon' => '081122334455',
            'keterangan' => 'Evakuasi satwa terlindungi dan mitigasi konflik hewan liar',
            'urutan' => 2,
        ]);

        KontakDarurat::create([
            'nama' => 'Pos Siaga Bencana BPBD',
            'instansi' => 'Badan Penanggulangan Bencana Daerah',
            'nomor_telepon' => '112',
            'keterangan' => 'Penyediaan logistik evakuasi dan tenda darurat',
            'urutan' => 3,
        ]);

        KontakDarurat::create([
            'nama' => 'Posko Satgas Jaga Hutan Desa',
            'instansi' => 'Pemerintah Desa Hutan Lestari',
            'nomor_telepon' => '081234567890',
            'keterangan' => 'Piket aparat desa dan koordinasi relawan warga',
            'urutan' => 4,
        ]);
    }
}
