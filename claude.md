# Jaga Hutan Desa

Website pengelolaan hutan untuk **Provinsi Jawa Barat**: peta kawasan hutan dan titik penting, laporan darurat dari warga (kebakaran dan hewan masuk kampung) tanpa login, pantauan status laporan, prediksi arah sebaran kebakaran, data primata dan tumbuhan Jawa Barat, serta informasi hutan. Dibangun dengan Laravel dan MySQL. Hanya ada **1 role: Admin**. Warga (publik) **tidak punya akun dan tidak login**. Aplikasi ini **hanya bekerja untuk wilayah Jawa Barat**.

## Cakupan Wilayah: Hanya Jawa Barat

Aplikasi ini hanya untuk **Provinsi Jawa Barat** (18 kabupaten dan 9 kota). Semua data, contoh, kontak, dan peta mengikuti wilayah ini.

- **Batas wilayah** (dibulatkan dari batas geografis di Perda Jawa Barat 9/2022): lintang -7.83 sampai -5.90, bujur 106.36 sampai 108.85. Disimpan di `pengaturan_hutan` sebagai `bbox_barat`, `bbox_selatan`, `bbox_timur`, `bbox_utara`. Titik tengah awal peta `-6.87, 107.60`, zoom awal 8.
- **Peta publik dan admin** dikunci di Jawa Barat dengan `maxBounds` Leaflet dari `bbox_*` dan `minZoom` 7.
- **Laporan** ditolak kalau lokasinya di luar batas dengan pesan "Lokasi laporan harus berada di wilayah Jawa Barat." Kotak batas ini sedikit melebihi perbatasan sebenarnya (ikut memuat sebagian Banten, DKI Jakarta, dan Jawa Tengah), jadi admin tetap boleh menghapus laporan yang ternyata di luar Jawa Barat.
- **Wilayah administrasi**: tabel `kabupaten_kota` berisi 27 kabupaten dan kota Jawa Barat dari seeder (tanpa CRUD). Dipakai untuk kawasan, titik penting, dan laporan.
- **Data awal** (kawasan hutan, titik penting, jenis lahan, primata, tumbuhan, kontak darurat) hanya yang ada di Jawa Barat dan diisi lewat seeder, lihat bagian "Data Awal Jawa Barat (Seeder)". Jangan memasukkan data provinsi lain (contoh: Taman Nasional Ujung Kulon di Banten tidak termasuk).
- **Teks tampilan**: slogan dan teks hero menyebut Jawa Barat. Semua contoh nama desa, dusun, kecamatan, dan kontak harus dari Jawa Barat.
- **Titik api satelit (FIRMS)** memakai kotak batas yang sama.

## URUTAN KERJA (BACA DULU SEBELUM MENGERJAKAN APA PUN)

1. Baca `CLAUDE.md` ini sampai selesai.
2. Kalau ada folder `referensi/` berisi PRD (`PRD-jaga-hutan-desa.html`) atau kode lama buatan sendiri, baca untuk memahami alur dan gaya penulisan kode.
3. Baru tulis kode, mengikuti ATURAN PENULISAN KODE di bawah.

Kalau ada perbedaan antara PRD dan `CLAUDE.md`, **`CLAUDE.md` yang jadi acuan final**. Belum ada mockup tampilan, jadi susunan halaman mengikuti deskripsi di bawah dan palet warna di bagian "Palet Warna dan Tampilan".

## ATURAN PENULISAN KODE (WAJIB DIPATUHI)

Kode di project ini harus sederhana dan bersih, terlihat ditulis manual oleh pelajar, bukan hasil generate.

1. **DILARANG menulis komentar di dalam kode.** Tidak ada `//`, `/* */`, `/** */` (PHP), `{{-- --}}` (Blade), `<!-- -->` (HTML), dan komentar di JavaScript/CSS.
2. **Kode harus sederhana.** Tidak boleh ada Repository, Service layer, Interface per class, Action class, DTO, Trait buatan sendiri, atau design pattern lain. Logika cukup di controller.
3. **Hindari sintaks yang terlihat canggih**: collection chaining panjang, arrow function bertingkat, `match` expression, null-safe operator bertumpuk, ternary bersarang, closure kompleks, scope Eloquent buatan sendiri. Pakai `if`, `foreach`, `for`, dan query Eloquent biasa (`where`, `orderBy`, `find`, `create`, `update`, `delete`).
4. **Yang penting jalan dan tidak error.** Utamakan kode yang lurus dan mudah dibaca daripada kode yang pintar.
5. Nama variabel, method, dan controller boleh campur Indonesia/Inggris (`$daftarLaporan`, `$dataKawasan`, `simpanLaporan`, `hitungElips`).
6. Semua teks untuk pengguna (label, pesan sukses, pesan error, validasi) ditulis dalam Bahasa Indonesia. Pesan validasi diberikan lewat parameter pesan di `validate()`.
7. Validasi memakai `$request->validate([...], [...pesan...])` langsung di controller. Tidak perlu Form Request class.
8. **DILARANG mengubah struktur tabel lewat kode di controller atau model.** Struktur tabel hanya lewat file migration. Data awal (akun admin, pengaturan, jenis lahan, kontak darurat) lewat seeder.
9. Query memakai Eloquent atau Query Builder. Kalau perlu query mentah, wajib pakai binding parameter, tidak boleh menyambung string dari input pengguna.
10. Tampilan memakai **Blade + Tailwind CSS (CDN) + Font Awesome**. Pengecualian: **Livewire 3** diizinkan HANYA untuk tiga hal: dropdown, pencarian, dan mode fullscreen. Inertia, Vue, React tetap dilarang. Jangan menulis direktif Alpine sendiri (x-data dan sejenisnya); Livewire sudah membawa Alpine, tetapi kita hanya memakai atribut `wire:`. Di luar tiga hal tersebut, JavaScript tetap ditulis sederhana dalam bentuk fungsi biasa (`bukaModal`, `tutupModal`, `kirimLaporan`, dst).
11. Library tambahan yang diizinkan: **Leaflet** dan **Leaflet.draw** (peta dan gambar poligon, keduanya lewat CDN cdnjs) serta package **livewire/livewire** (Livewire 3 untuk dropdown, pencarian, dan fullscreen). Pemanggilan API luar memakai `Http` bawaan Laravel (bukan package Composer tambahan). Library atau package lain tanya dulu.
12. Fitur yang tidak ada di `CLAUDE.md` ini tidak boleh ditambahkan hanya karena ada di PRD atau terpikir bagus. Kalau ragu, tanya dulu.

Aturan ini berlaku untuk semua perubahan berikutnya, tanpa perlu diingatkan lagi.

## Tech Stack

- **Backend**: Laravel 11/12, PHP 8.2+
- **Frontend Reaktif**: Livewire 3 (khusus dropdown, pencarian, dan mode fullscreen)
- **Database**: MySQL (XAMPP/Laragon saat development)
- **Tampilan**: Blade + Tailwind CSS lewat CDN (`https://cdn.tailwindcss.com`) + Font Awesome 6.4 + font Inter (Google Fonts)
- **Autentikasi**: login manual dengan `Auth::attempt` (username + password), tanpa Breeze/Jetstream. Hanya untuk admin.
- **Peta**: Leaflet 1.9.4 dan Leaflet.draw 1.0.4 dari cdnjs. Gambar peta (tile) dari OpenStreetMap (`https://tile.openstreetmap.org/{z}/{x}/{y}.png`) dengan tulisan atribusi OpenStreetMap di peta. Marker memakai `L.circleMarker` berwarna (bukan gambar ikon) supaya tidak ada masalah file ikon.
- **Lokasi warga**: `navigator.geolocation` di browser. Kalau GPS gagal atau ditolak, warga bisa menunjuk lokasi dengan menekan peta.
- **Cuaca dan angin**: API Open-Meteo (gratis, tanpa API key), dipanggil dari server Laravel.
- **Titik api satelit**: NASA FIRMS (area CSV API), butuh `MAP_KEY` gratis. Disimpan di `.env` sebagai `FIRMS_MAP_KEY` dan dibaca lewat `config/services.php`. Tidak boleh dikirim ke browser atau ditulis di log.
- **Upload file**: `storage/app/public` dengan `php artisan storage:link`
- **Zona waktu**: `Asia/Jakarta`, locale `id` (di `config/app.php`)

**Catatan penting kamera dan lokasi:** browser hanya mengizinkan GPS di halaman **HTTPS** atau `localhost`. Saat dites dari HP lewat IP jaringan lokal (`http://192.168.x.x`), lokasi akan diblokir. Untuk uji coba di HP pakai tunnel HTTPS (contoh ngrok) atau hosting yang punya SSL.

**Catatan API luar:** sebelum menulis URL atau parameter Open-Meteo dan NASA FIRMS, buka dulu dokumentasi resminya (`open-meteo.com/en/docs` dan `firms.modaps.eosdis.nasa.gov/api`). Free tier Open-Meteo hanya untuk non-komersial. Kalau API gagal atau lambat, aplikasi tidak boleh error: tampilkan pesan Bahasa Indonesia dan beri jalan keluar (isi manual).

## Struktur Project

```
jaga-hutan-desa/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PublikController.php        beranda, peta, primata, tumbuhan, info hutan, prediksi publik
│   │   │   ├── LaporController.php         form lapor, simpan, sinkron offline, cek status
│   │   │   ├── LoginController.php
│   │   │   └── Admin/                      DashboardController, PengaturanController, KawasanController, TitikPentingController,
│   │   │                                   JenisLahanController, LaporanController, TitikApiController, PrediksiController,
│   │   │                                   PrimataController, TumbuhanController, PengumumanController,
│   │   │                                   JadwalPatroliController, KontakDaruratController, AkunController
│   ├── Livewire/                           komponen pencarian, dropdown, dan mode fullscreen
│   └── Models/                             satu model per tabel
├── database/
│   ├── migrations/
│   └── seeders/                            DatabaseSeeder (akun admin, pengaturan_hutan, jenis_lahan, kontak_darurat, data contoh)
├── resources/views/
│   ├── layouts/                            publik.blade.php, admin.blade.php (sidebar)
│   ├── partials/                           modal-pesan.blade.php
│   ├── livewire/                           tampilan komponen Livewire
│   ├── publik/
│   ├── admin/
│   └── login.blade.php
├── routes/web.php
└── public/storage/                         hasil storage:link (jangan diedit manual)
```

## Hak Akses

- Hanya ada satu role, **Admin**. Tabel `users` tidak punya kolom role.
- Semua route `/admin/...` memakai middleware `auth`. Yang belum login diarahkan ke halaman login.
- Akun dengan `status = Nonaktif` ditolak saat login dengan pesan jelas.
- Halaman publik, form lapor, dan cek status **tidak butuh login**.
- Tombol **Keluar** di sidebar admin: logout lalu kembali ke beranda publik.
- **Lupa Kata Sandi**: tanpa email. Halaman login punya tautan "Lupa kata sandi?" yang membuka halaman berisi petunjuk: hubungi admin lain untuk direset lewat menu Akun Admin. Admin yang ganti password sendiri lewat menu Akun Admin juga.

## Palet Warna dan Tampilan

| Elemen                         | Kelas Tailwind                                                          |
| ------------------------------ | ----------------------------------------------------------------------- |
| Navbar publik                  | `bg-green-900 text-white`, tinggi `h-20`, `sticky top-0`                |
| Hero beranda                   | `bg-gradient-to-r from-green-950 via-green-900 to-stone-900`            |
| Tombol utama                   | `bg-green-700 hover:bg-green-600 text-white rounded-xl`                 |
| Tombol darurat (Lapor)         | `bg-red-600 hover:bg-red-500 text-white font-bold rounded-xl`           |
| Sidebar admin                  | `bg-stone-900 text-stone-300`, lebar `md:w-64`                          |
| Menu sidebar aktif / hover     | `bg-green-700 text-white` / `hover:bg-stone-800 hover:text-white`       |
| Latar halaman                  | `bg-stone-50`, teks `text-stone-800`, font Inter                        |
| Card                           | `bg-white rounded-2xl shadow-sm border border-stone-100 p-6`            |
| Header tabel                   | `bg-stone-100 text-stone-700 uppercase text-xs`, baris `divide-y divide-stone-100` |
| Input                          | `px-4 py-2.5 rounded-xl border border-stone-200 outline-none`           |
| Tombol hapus / keluar          | `text-rose-600` / `bg-rose-50 text-rose-600`                            |
| Modal                          | overlay `bg-stone-950/60 backdrop-blur-sm`, kotak `bg-white rounded-3xl p-8 max-w-md` |
| Footer publik                  | `bg-stone-950 text-stone-400`, 4 kolom                                  |

**Badge status laporan:** Baru `bg-rose-100 text-rose-800`, Diverifikasi `bg-amber-100 text-amber-800`, Ditangani `bg-sky-100 text-sky-800`, Selesai `bg-emerald-100 text-emerald-800`.

**Badge status konservasi (primata dan tumbuhan):** Kritis (CR) `bg-red-100 text-red-800`, Terancam (EN) `bg-orange-100 text-orange-800`, Rentan (VU) `bg-yellow-100 text-yellow-800`, Hampir Terancam (NT) `bg-lime-100 text-lime-800`, Risiko Rendah (LC) `bg-green-100 text-green-800`, Data Kurang (DD) `bg-stone-100 text-stone-700`, Belum Dinilai (NE) `bg-stone-50 text-stone-500 border border-stone-200`.

**Warna marker di peta (`L.circleMarker`):**

| Data                         | Warna                |
| ---------------------------- | -------------------- |
| Laporan Kebakaran            | merah `#dc2626`      |
| Laporan Hewan Masuk Kampung  | oranye `#ea580c`     |
| Titik api satelit            | ungu `#7e22ce`       |
| Pos Jaga                     | biru `#2563eb`       |
| Pos Pemadam                  | merah tua `#991b1b`  |
| Sumber Air                   | cyan `#0891b2`       |
| Titik Kumpul Evakuasi        | hijau `#16a34a`      |
| Permukiman                   | kuning `#ca8a04`     |

Poligon kawasan hutan: garis hijau `#15803d`, isi hijau transparan. Poligon prediksi api: 1 jam merah, 3 jam oranye, 6 jam kuning (semua transparan).

- Logo di navbar dan footer: kotak `bg-white text-green-900 font-black rounded-xl` berisi ikon pohon Font Awesome (atau logo upload kalau sudah diisi di Pengaturan), di sebelahnya nama aplikasi.
- Format tanggal Indonesia (`Senin, 19 Oktober 2026`) lewat Carbon dengan locale `id`.
- **Semua halaman publik harus nyaman di HP** (mobile first), terutama form lapor dan peta, karena warga memakai HP di lapangan dengan sinyal yang sering lemah. Tombol besar, teks jelas.
- Tombol melayang **Lapor Darurat** (merah, pojok kanan bawah) tampil di semua halaman publik.

## Halaman Publik

Memakai `layouts/publik.blade.php`: navbar, isi halaman, footer. Semua isi dari database. Menu navbar: **Beranda, Peta Hutan, Primata, Tumbuhan, Info Hutan, Peringatan**, dan tombol merah **Lapor Darurat**. Tidak ada tombol login di navbar. Halaman login admin dibuka lewat `/login` dan tautan kecil **Login Admin** di footer. Di layar kecil menu jadi hamburger.

- **Beranda** (`/`): (1) hero dengan slogan, paragraf singkat, dan dua tombol besar **Lapor Kebakaran** dan **Lapor Hewan Masuk Kampung**; (2) kartu **Peringatan Area Terancam** kalau ada prediksi yang ditampilkan ke publik (lihat Prediksi); (3) kartu statistik (jumlah kawasan, primata, tumbuhan, laporan selesai); (4) **Kabar dan Pengumuman terbaru** (3 terbaru berstatus Publish); (5) strip **Kontak Darurat**.
- **Peta Hutan** (`/peta`): peta Leaflet layar penuh. Isi: poligon kawasan hutan, titik penting, dan laporan yang statusnya **Diverifikasi, Ditangani** (laporan Baru dan Selesai tidak ditampilkan di peta publik). Ada kotak centang untuk menyalakan atau mematikan tiap lapisan (Kawasan, Titik Penting, Laporan). Klik poligon atau marker membuka popup **Detail Titik**: nama, jenis, deskripsi, foto, dan kontak. Nomor HP pelapor dan nama pelapor **tidak pernah** ditampilkan di halaman publik. Peta dikunci di Jawa Barat (`maxBounds` dari `bbox_*`) dan awalnya menampilkan seluruh Jawa Barat. Poligon kawasan yang `batas_resmi = 0` diberi keterangan "Batas perkiraan" di popup.
- **Primata** (`/primata`, `/primata/{id}`): grid kartu (foto, nama lokal, nama ilmiah, badge status konservasi, tanda Dilindungi). Pencarian nama dan filter kawasan. Halaman detail berisi semua data, daftar kawasan tempat ditemukan, dan tautan **Lapor Hewan Masuk Kampung**.
- **Tumbuhan** (`/tumbuhan`, `/tumbuhan/{id}`): sama seperti Primata, dengan filter jenis (Pohon, Perdu, Herba, Liana, Lainnya) dan kawasan.
- **Info Hutan** (`/info`, `/info/{id}`): tiga tab sederhana, **Kabar & Pengumuman**, **Jadwal Patroli & Kegiatan**, **Tips Keselamatan**, ditambah daftar **Kontak Darurat** (damkar, BKSDA, BPBD, nomor desa) dengan tombol telepon (`tel:`). Tab Kabar dan Tips diambil dari tabel `pengumuman` berdasarkan kategori.
- **Peringatan** (`/peringatan`): menampilkan prediksi kebakaran yang ditandai **Tampil Publik** oleh admin: peta dengan poligon 1, 3, dan 6 jam, daftar permukiman yang terancam beserta perkiraan waktunya, dan keterangan bahwa ini perkiraan, bukan pengganti arahan petugas. Kalau tidak ada: "Saat ini tidak ada peringatan kebakaran."
- **Lapor Darurat** (`/lapor`): lihat bagian berikutnya.
- **Cek Status Laporan** (`/lapor/status`): lihat bagian berikutnya.
- **Footer**: logo + alamat, Tautan Cepat, Kontak Darurat, tautan Login Admin, teks hak cipta.
- Kalau data kosong, tampilkan pesan ramah ("Belum ada data primata"), jangan tampilkan area kosong.

## Lapor Darurat dan Cek Status (tanpa login)

**Form lapor** (`/lapor`, bisa dibuka dengan `?jenis=Kebakaran` atau `?jenis=Hewan Masuk Kampung` dari tombol di beranda):
- Jenis laporan: **Kebakaran** atau **Hewan Masuk Kampung** (hanya dua ini).
- Lokasi: tombol **Gunakan Lokasi Saya** (GPS otomatis) dan peta kecil untuk menunjuk lokasi manual. Latitude dan longitude terisi dari salah satunya. Laporan tidak bisa dikirim tanpa lokasi. Tambahkan dropdown **Kabupaten/Kota** (opsional, dari tabel `kabupaten_kota`).
- Untuk Hewan Masuk Kampung ada isian **Jenis hewan** (teks bebas, contoh "monyet ekor panjang").
- Deskripsi singkat, foto (opsional), nama pelapor (opsional), nomor HP (opsional, tidak ditampilkan di publik, hanya dilihat admin).
- Setelah kirim, tampil halaman sukses berisi **kode laporan** besar (format `JHD-XXXXXX`, 6 karakter huruf besar dan angka tanpa `0 O 1 I L`, dibuat dengan `random_int`, dipastikan unik dengan perulangan) dan tombol salin. Peringatan: "Simpan kode ini untuk mengecek status laporan."
- Setiap kode laporan yang berhasil juga disimpan di `localStorage` perangkat (kunci `kodeLaporanSaya`) supaya warga bisa melihat riwayat laporannya di perangkat itu.

**Cek Status** (`/lapor/status`): kolom masukkan kode, lalu tampil jenis, waktu lapor, status (badge), dan catatan admin. Tidak menampilkan data pelapor. Di bawahnya tampil **Riwayat laporan di perangkat ini** dari `localStorage` (tiap kode bisa diklik untuk dicek). Kode yang tidak ditemukan: "Kode laporan tidak ditemukan."

**Mode offline sederhana** (di halaman Lapor):
- Kalau pengiriman gagal karena tidak ada sinyal, laporan disimpan di `localStorage` (kunci `laporanTertunda`, berisi jenis, jenis hewan, latitude, longitude, deskripsi, nama, nomor HP, dan waktu dibuat). **Foto tidak ikut disimpan offline** (terlalu besar), dan warga diberi tahu.
- Tampil pesan: "Tidak ada sinyal. Laporan disimpan di HP dan akan dikirim otomatis saat sinyal kembali."
- Saat event `online` muncul, atau saat halaman Lapor dibuka dan sinyal ada, laporan tertunda dikirim satu per satu lewat `fetch` ke `POST /lapor/sinkron` (balasan JSON berisi kode). Yang berhasil dihapus dari antrean dan kodenya masuk riwayat.
- Batasan yang diterima: mode ini hanya bekerja kalau halaman Lapor **sudah terbuka** sebelum sinyal hilang. Service worker/PWA penuh ditunda, jangan ditambahkan kecuali diminta.

**Pencegahan spam dan keamanan:**
- `POST /lapor` dan `POST /lapor/sinkron` memakai `throttle:5,60` (maksimal 5 laporan per jam per IP). `GET/POST /lapor/status` memakai `throttle:20,1`.
- Kedua route kirim laporan **dikecualikan dari verifikasi CSRF** (di `bootstrap/app.php`, lewat `validateCsrfTokens(except: [...])`) karena tidak memakai sesi login dan halaman bisa terbuka lama saat offline, sehingga token bisa kadaluarsa. Perlindungan diganti throttle dan verifikasi admin.
- Alamat IP disimpan di `ip_pelapor` untuk keperluan admin.
- Validasi: jenis harus salah satu dari dua pilihan, latitude dan longitude harus berada di dalam batas wilayah Jawa Barat (nilai `bbox_*` dari `pengaturan_hutan`, dicek dengan `if` di controller, pesan "Lokasi laporan harus berada di wilayah Jawa Barat."), deskripsi maksimal 1000 karakter, foto `image|mimes:jpg,jpeg,png|max:5120`, nomor HP hanya angka dan tanda `+`, maksimal 20 karakter.
- Laporan baru berstatus `Baru` dan **tidak dianggap sah** sampai admin mengubahnya menjadi Diverifikasi.

## Dashboard Admin

Layout `layouts/admin.blade.php`: sidebar kiri (`md:w-64`, di HP menjadi blok di atas) berisi logo + tulisan **ADMINISTRATOR / Jaga Hutan Desa**, daftar menu, dan tombol **Keluar** di bawah. Konten di kanan. Menu **Kelola Laporan** menampilkan badge merah berisi jumlah laporan berstatus Baru (boleh satu baris query hitung langsung di `layouts/admin.blade.php`).

**Urutan menu sidebar:**

```
Dashboard
A. Kawasan Hutan
B. Titik Penting
C. Kelola Laporan
D. Prediksi Kebakaran
E. Primata
F. Tumbuhan
G. Pengumuman
H. Jadwal Patroli
I. Kontak Darurat
J. Jenis Lahan
K. Akun Admin
L. Pengaturan
```

**Pola CRUD sederhana** (menu E, F, G, H, I, J, K): judul halaman + tombol hijau di kanan atas (Tambah ...), isi berupa tabel, kolom Aksi berisi **Edit** dan **Hapus**. Tambah dan Edit memakai **modal**. Pada Edit, field modal diisi lewat atribut `data-*` pada tombol Edit lewat fungsi JavaScript sederhana. Modal Tambah selalu kosong. Menu yang butuh peta (A dan B) memakai **halaman form sendiri**, bukan modal.

**Dashboard**: kartu statistik (laporan Baru, kebakaran aktif, hewan masuk kampung bulan ini, jumlah kawasan, primata, tumbuhan); **grafik batang sederhana** laporan per bulan untuk 6 bulan terakhir (dibuat dengan `div` Tailwind berlebar persen, tanpa library grafik); daftar **Kawasan Paling Rawan** (jumlah laporan kebakaran per kawasan, 5 teratas); dan 5 laporan terbaru. Dashboard dikerjakan paling akhir karena merangkum semua modul. Tambahkan juga daftar **Kabupaten/Kota Paling Rawan** (jumlah laporan kebakaran per kabupaten/kota, 5 teratas).

**A. Kawasan Hutan**: tabel Nama, Jenis Lahan, Luas (ha), Aksi. Halaman Tambah/Edit berisi peta Leaflet dengan **Leaflet.draw** (hanya alat gambar poligon, satu poligon per kawasan). Hasil gambar disimpan sebagai **GeoJSON** di kolom `geojson`. Field: Nama, Deskripsi, Jenis Lahan (dropdown dari tabel `jenis_lahan`), Luas (opsional). Primata dan tumbuhan yang ada di kawasan ini dipilih dari halaman Primata dan Tumbuhan, bukan di sini. Field tambahan: **Kategori** (Taman Nasional, Cagar Alam, Suaka Margasatwa, Taman Wisata Alam, Taman Buru, Taman Hutan Raya, Hutan Lindung, Hutan Produksi, Lainnya), **Pengelola**, **Kabupaten/Kota** (kotak centang beberapa), titik pusat (latitude dan longitude), dan kotak centang **Batas sudah sesuai data resmi** (kolom `batas_resmi`). Selama kotak itu belum dicentang, daftar dan peta menampilkan badge "Batas perkiraan".

**B. Titik Penting**: tabel Nama, Jenis, Kawasan, Aksi. Halaman Tambah/Edit: peta, klik peta untuk menaruh titik (latitude dan longitude terisi otomatis). Field: Nama, Jenis (**Pos Jaga, Pos Pemadam, Sumber Air, Titik Kumpul Evakuasi, Permukiman**), Deskripsi, Foto (upload, opsional), Kontak (opsional), Kawasan (dropdown, opsional). Titik berjenis **Permukiman** dipakai untuk Peringatan Area Terancam. Tambahkan dropdown Kabupaten/Kota (opsional).

**C. Kelola Laporan**: tabel Kode, Jenis, Waktu, Lokasi, Status (badge), Aksi, dengan filter status dan jenis, urut terbaru, pagination 10. Halaman detail laporan menampilkan peta kecil dengan lokasi, foto, deskripsi, nama dan nomor HP pelapor (hanya admin), serta form: **Status** (Baru, Diverifikasi, Ditangani, Selesai), **Kawasan** (dropdown), **Catatan Admin** (tampil ke warga di Cek Status). Tombol **Hitung Prediksi dari Titik Ini** (hanya untuk laporan Kebakaran) membuka halaman Prediksi dengan lokasi terisi. Laporan bisa dihapus (dengan konfirmasi), misalnya untuk laporan palsu. Tambahkan filter **Kabupaten/Kota**, dan admin mengisi Kabupaten/Kota laporan bersama Kawasan.

**D. Prediksi Kebakaran**: lihat bagian Prediksi Kebakaran di bawah.

**E. Primata**: tabel Foto, Nama Lokal, Nama Ilmiah, Status Konservasi (badge), Dilindungi, Aksi. Modal: Nama Lokal, Nama Ilmiah, Status Konservasi (CR/EN/VU/NT/LC/DD/NE), Dilindungi (checkbox), Habitat, Makanan, Ciri Khas, Deskripsi, Foto (upload), **Kawasan** (kotak centang beberapa kawasan).

**F. Tumbuhan**: sama seperti Primata, dengan Jenis (Pohon/Perdu/Herba/Liana/Lainnya) dan Manfaat sebagai pengganti Makanan dan Ciri Khas.

**G. Pengumuman**: tabel Judul, Kategori, Tanggal, Status, Aksi. Modal: Judul, Kategori (**Kabar, Pengumuman, Tips Keselamatan**), Isi, Gambar (upload, opsional), Status (Draft/Publish).

**H. Jadwal Patroli**: modal berisi Judul Kegiatan, Tanggal, Jam, Lokasi, Keterangan. Tampil di Info Hutan, yang sudah lewat tidak ditampilkan di publik tapi tetap ada di admin.

**I. Kontak Darurat**: modal berisi Nama, Instansi, Nomor Telepon, Keterangan, Urutan tampil.

**J. Jenis Lahan**: modal berisi Nama, **Laju Dasar Api (meter per jam)**, Keterangan. Dipakai sebagai faktor prediksi. Seeder mengisi nilai awal (lihat bagian Prediksi).

**K. Akun Admin**: tabel Nama, Username, Status, Aksi. Modal: Nama, Username (unik, huruf kecil), Password (wajib saat Tambah, saat Edit kosong berarti tidak diganti), Status. Akun yang sedang login tidak boleh dihapus, dan tidak boleh menonaktifkan diri sendiri.

**L. Pengaturan**: form berisi Nama Aplikasi, Nama Instansi, Slogan, Deskripsi Singkat, Alamat, Email, Telepon, Logo (upload), serta **Pengaturan Peta**: Latitude Pusat, Longitude Pusat, Zoom Awal, dan **Batas Wilayah** (Barat, Selatan, Timur, Utara) yang dipakai untuk validasi lokasi laporan, batas peta, dan pencarian titik api. Tombol **Simpan Perubahan**.

## Prediksi Kebakaran

Halaman admin `D. Prediksi Kebakaran`. Isinya, dari atas ke bawah:

1. **Peta** dengan kawasan, permukiman, laporan Kebakaran yang belum Selesai, dan **titik api satelit** (ungu).
2. Tombol **Ambil Titik Api Satelit** (lihat bawah).
3. **Form prediksi**: Latitude, Longitude (terisi dari laporan, klik peta, atau diketik), Jenis Lahan (dropdown), lalu tombol **Ambil Data Cuaca**.
4. Setelah Ambil Data Cuaca, field **Arah Angin (derajat)**, **Kecepatan Angin (km/jam)**, **Kelembapan (%)**, dan **Curah Hujan (mm)** terisi dari Open-Meteo dan **masih bisa diedit manual**. Kalau API gagal, field kosong dan admin mengisi sendiri.
5. Tombol **Hitung Prediksi** menghitung dan menyimpan hasil ke `prediksi_api`, lalu menampilkan poligon 1, 3, dan 6 jam di peta, luas tiap poligon (ha), dan daftar **Area Terancam**.
6. Checkbox/tombol **Tampilkan ke Publik** per prediksi (kolom `tampil_publik`). Hanya prediksi yang ditandai ini yang muncul di halaman Peringatan dan beranda. Riwayat prediksi ditampilkan di bawah sebagai tabel dengan tombol Lihat, Tampilkan/Sembunyikan, dan Hapus.
7. Keterangan tetap di halaman: "Hasil ini perkiraan sederhana dan bukan pengganti keputusan petugas lapangan."

**Data cuaca (Open-Meteo, server side).** Dipanggil dengan `Http::timeout(10)->get(...)` dari controller (tidak dari browser). Ambil nilai saat ini: suhu, kelembapan relatif, curah hujan, kecepatan angin 10 m (km/jam), dan arah angin 10 m. Sebelum menulis URL, cek dokumentasi. **Arah angin dari Open-Meteo adalah arah ASAL angin** (derajat dari utara, searah jarum jam), sehingga **arah rambat api = (arah_angin + 180) % 360**.

**Titik api satelit (NASA FIRMS).** Tombol Ambil Titik Api Satelit memanggil API area CSV FIRMS dengan kotak area dari `bbox_barat`, `bbox_selatan`, `bbox_timur`, `bbox_utara` (urutan di API: barat, selatan, timur, utara), 1 hari terakhir. Cek dokumentasi FIRMS untuk batas ukuran area; kalau ditolak, bagi kotak menjadi dua panggilan. Titik yang jatuh sedikit di luar batas administrasi Jawa Barat tidak dipermasalahkan. Hasil CSV diurai dengan `str_getcsv` dan disimpan ke `titik_api` (lewati yang sudah ada). Agar tidak membebani API, jangan memanggil lagi kalau `terakhir_ambil_firms` di `pengaturan_hutan` masih kurang dari 30 menit; tampilkan pesan "Data baru saja diambil." Kalau `FIRMS_MAP_KEY` kosong, tampilkan pesan bahwa kunci belum diisi.

**Rumus perkiraan** (model elips sederhana, bukan simulasi grid, supaya kode lurus). Semua angka di bawah adalah **nilai awal perkiraan, bukan data ilmiah**, dan bisa diubah di Jenis Lahan atau di controller:

```
lajuEfektif = lajuDasar * (1 + kecepatanAngin / 10) * faktorKelembapan * faktorHujan
```

- `lajuDasar`: dari `jenis_lahan.laju_dasar` (meter per jam). Nilai awal untuk 8 jenis lahan Jawa Barat ada di bagian "Data Awal Jawa Barat (Seeder)".
- `faktorKelembapan`: kelembapan 80 ke atas = 0.5; 60 sampai 79 = 0.8; 40 sampai 59 = 1; di bawah 40 = 1.3.
- `faktorHujan`: kalau curah hujan lebih dari 0 = 0.3, selain itu 1.
- Untuk tiap jam `j` (1, 3, 6): `depan = lajuEfektif * j`, `belakang = depan * 0.2`, `a = (depan + belakang) / 2`, `geser = (depan - belakang) / 2`, `rasio = 1 + kecepatanAngin / 10` (maksimal 4), `b = a / rasio`.
- Luas (ha) = `pi() * a * b / 10000`.

```php
public function hitungElips($lat, $long, $arahRambat, $a, $b, $geser)
{
    $titik = [];
    $sudutRambat = deg2rad($arahRambat);
    for ($i = 0; $i < 36; $i++) {
        $t = deg2rad($i * 10);
        $u = $geser + $a * cos($t);
        $v = $b * sin($t);
        $timur = $u * sin($sudutRambat) + $v * cos($sudutRambat);
        $utara = $u * cos($sudutRambat) - $v * sin($sudutRambat);
        $lintang = $lat + $utara / 111320;
        $bujur = $long + $timur / (111320 * cos(deg2rad($lat)));
        $titik[] = [$lintang, $bujur];
    }
    return $titik;
}
```

**Area Terancam.** Untuk setiap titik penting berjenis Permukiman, ubah posisinya ke koordinat lokal terhadap titik api: `utara = (lat - lat0) * 111320`, `timur = (long - long0) * 111320 * cos(deg2rad(lat0))`, `u = timur * sin(sudut) + utara * cos(sudut)`, `v = timur * cos(sudut) - utara * sin(sudut)`. Permukiman dianggap terancam pada jam `j` kalau `((u - geser) / a)^2 + (v / b)^2 <= 1` untuk elips jam itu. Ambil jam terkecil (1, 3, atau 6) yang mengenainya. Hasilnya (nama permukiman dan jam) disimpan sebagai JSON di kolom `area_terancam` saat prediksi disimpan, jadi halaman publik cukup membacanya.

**Ditunda untuk prediksi:** kemiringan lereng (elevasi), peta satelit, simulasi grid, machine learning. Jangan ditambahkan kecuali diminta.

## Aturan Tabel dan Form

- Tabel: `w-full text-left text-sm`, header `bg-stone-100 text-stone-700 uppercase text-xs` dengan sudut membulat di ujung, kontainer `overflow-x-auto`. Pagination `paginate(10)` dengan `->links()`.
- Kolom pencarian di atas tabel (`?cari=`), hasil tetap berpagination dan pencarian terbawa saat pindah halaman (`withQueryString()`).
- Data kosong: tampilkan pesan "Belum ada data" atau "Tidak ada data yang cocok", jangan tampilkan tabel kosong.
- Hapus selalu dengan konfirmasi (`confirm()` JavaScript) dan memakai form dengan `@method('DELETE')`.
- Setelah simpan/hapus, kembali ke halaman daftar dengan pesan flash yang ditampilkan lewat `partials/modal-pesan` (judul **Berhasil** / **Informasi**, tombol **Mengerti**). Error validasi ditampilkan sebagai kotak merah (`bg-rose-50 text-rose-700 rounded-xl`) di atas halaman berisi daftar pesan.
- Semua form admin memakai `@csrf` (kecuali dua route kirim laporan publik, lihat bagian Lapor Darurat).
- Upload gambar admin: validasi `image|mimes:jpg,jpeg,png|max:2048`. Simpan ke `storage/app/public/{folder}` dengan nama unik. Saat gambar diganti atau data dihapus, file lama ikut dihapus.
- Hapus data yang masih dipakai (jenis lahan yang dipakai kawasan, kawasan yang dipakai laporan atau titik penting) harus ditolak dengan pesan jelas, jangan biarkan error foreign key muncul mentah.
- Pesan error teknis (exception) tidak boleh ditampilkan mentah ke pengguna.
- Peta di halaman admin dan publik harus punya tinggi tetap (contoh `h-96`, di halaman Peta Hutan `h-[70vh]`) dan memanggil `peta.invalidateSize()` kalau ditaruh di dalam modal atau tab.

## Database

Dibuat lewat **migration** dan data awal lewat **seeder**. Primary key `id` bawaan Laravel, kolom status pakai `string` dengan nilai default, tanpa tabel lookup terpisah. Nama tabel dan kolom memakai Bahasa Indonesia, huruf kecil, dipisah garis bawah, dan model diberi `protected $table`. Koordinat disimpan sebagai `decimal(10,7)`.

### users
`id`, `name`, `username` (unik), `password` (bcrypt via `Hash::make`), `status` (default `Aktif`), timestamps. Seeder membuat 1 akun admin awal.

### pengaturan_hutan
Satu baris saja (id selalu 1): `nama_aplikasi`, `nama_instansi`, `slogan`, `deskripsi_singkat`, `alamat`, `email`, `telepon`, `logo`, `lat_pusat` (default -6.87), `long_pusat` (default 107.60), `zoom_awal` (default 8), `bbox_barat` (default 106.36), `bbox_selatan` (default -7.83), `bbox_timur` (default 108.85), `bbox_utara` (default -5.90), `terakhir_ambil_firms` (datetime, nullable).

### jenis_lahan
`id`, `nama` (unik), `laju_dasar` (INT, meter per jam), `keterangan` (nullable).

### kabupaten_kota
`id`, `nama` (unik, contoh `Kabupaten Garut`, `Kota Bandung`), `jenis` (`Kabupaten` / `Kota`). Diisi seeder, tanpa CRUD.

### kawasan_kabupaten
Tabel penghubung: `id_kawasan` (FK), `id_kabupaten_kota` (FK). Satu kawasan bisa berada di beberapa kabupaten/kota.

### kawasan_hutan
`id`, `nama`, `kategori` (`Taman Nasional` / `Cagar Alam` / `Suaka Margasatwa` / `Taman Wisata Alam` / `Taman Buru` / `Taman Hutan Raya` / `Hutan Lindung` / `Hutan Produksi` / `Lainnya`), `pengelola` (nullable), `deskripsi`, `luas_ha` (nullable), `lat_pusat`, `long_pusat`, `geojson` (longText), `batas_resmi` (boolean, default 0), `id_jenis_lahan` (FK).

### titik_penting
`id`, `nama`, `jenis` (`Pos Jaga` / `Pos Pemadam` / `Sumber Air` / `Titik Kumpul Evakuasi` / `Permukiman`), `latitude`, `longitude`, `deskripsi`, `foto` (nullable), `kontak` (nullable), `id_kawasan` (nullable, FK), `id_kabupaten_kota` (nullable, FK).

### laporan
`id`, `kode` (unik), `jenis` (`Kebakaran` / `Hewan Masuk Kampung`), `jenis_hewan` (nullable), `latitude`, `longitude`, `deskripsi`, `foto` (nullable), `nama_pelapor` (nullable), `no_hp` (nullable), `status` (default `Baru`), `catatan_admin` (nullable), `id_kawasan` (nullable, FK), `id_kabupaten_kota` (nullable, FK), `id_admin` (nullable, FK `users`, admin yang terakhir mengubah), `ip_pelapor`, timestamps.

### titik_api
`id`, `latitude`, `longitude`, `tanggal_deteksi` (DATE), `waktu_deteksi` (string), `kepercayaan` (string), `sumber` (default `VIIRS`), timestamps. Kombinasi `latitude` + `longitude` + `tanggal_deteksi` + `waktu_deteksi` **unik**.

### prediksi_api
`id`, `id_laporan` (nullable, FK), `latitude`, `longitude`, `id_jenis_lahan` (FK), `arah_angin`, `kecepatan_angin`, `kelembapan`, `curah_hujan` (semua angka desimal), `laju_efektif`, `poligon_1jam`, `poligon_3jam`, `poligon_6jam` (longText, JSON titik), `luas_1jam`, `luas_3jam`, `luas_6jam` (desimal, ha), `area_terancam` (text, JSON), `tampil_publik` (boolean, default 0), `id_admin` (FK `users`), timestamps.

### primata
`id`, `nama_lokal`, `nama_ilmiah`, `status_konservasi` (`CR` / `EN` / `VU` / `NT` / `LC` / `DD` / `NE`), `dilindungi` (boolean), `habitat`, `makanan`, `ciri_khas`, `deskripsi`, `foto` (nullable).

### tumbuhan
`id`, `nama_lokal`, `nama_ilmiah`, `jenis` (`Pohon` / `Perdu` / `Herba` / `Liana` / `Lainnya`), `status_konservasi` (nilai sama seperti tabel primata), `dilindungi` (boolean), `manfaat`, `deskripsi`, `foto` (nullable).

### kawasan_primata dan kawasan_tumbuhan
Tabel penghubung: `id_kawasan` (FK), `id_primata` atau `id_tumbuhan` (FK). Relasi `belongsToMany` biasa di model.

### pengumuman
`id`, `judul`, `kategori` (`Kabar` / `Pengumuman` / `Tips Keselamatan`), `isi`, `gambar` (nullable), `tanggal`, `status` (default `Draft`), `id_user`, timestamps.

### jadwal_patroli
`id`, `judul`, `tanggal` (DATE), `jam`, `lokasi`, `keterangan` (nullable).

### kontak_darurat
`id`, `nama`, `instansi`, `nomor_telepon`, `keterangan` (nullable), `urutan` (INT, default 0).

## Data Awal Jawa Barat (Seeder)

Data di bagian ini diisi lewat seeder supaya admin tidak perlu memasukkan satu per satu. Hasil riset dikumpulkan Oktober 2026. Ini **titik awal, bukan data resmi**: koordinat adalah titik pusat perkiraan, batas poligon adalah lingkaran perkiraan, dan sebaran satwa serta tumbuhan harus diverifikasi admin dengan BBKSDA Jawa Barat dan balai taman nasional terkait.

**Aturan seeder:**
- Pecah menjadi seeder terpisah: `KabupatenKotaSeeder`, `JenisLahanSeeder`, `KawasanHutanSeeder`, `PrimataSeeder`, `TumbuhanSeeder`, `TitikPentingSeeder`, `KontakDaruratSeeder`, `PengumumanSeeder`. `DatabaseSeeder` memanggil semuanya berurutan. Data ditulis sebagai array biasa, tanpa komentar.
- Semua kawasan dibuat dengan `batas_resmi = 0`.
- Poligon perkiraan dibuat di seeder dengan perulangan `for` (8 titik) dari titik pusat dan `radius_km` pada tabel kawasan di bawah. Urutan koordinat GeoJSON adalah `[bujur, lintang]`. Kalau luas kawasan kosong (`-`), kolom `luas_ha` dibiarkan `null`.

```php
$titik = [];
for ($i = 0; $i < 8; $i++) {
    $sudut = deg2rad($i * 45);
    $lintang = $latPusat + ($radiusKm * cos($sudut)) / 111.32;
    $bujur = $longPusat + ($radiusKm * sin($sudut)) / (111.32 * cos(deg2rad($latPusat)));
    $titik[] = [$bujur, $lintang];
}
$titik[] = $titik[0];
$geojson = json_encode(['type' => 'Polygon', 'coordinates' => [$titik]]);
```

### Kabupaten dan Kota (27)

- **Kabupaten (18):** Bandung, Bandung Barat, Bekasi, Bogor, Ciamis, Cianjur, Cirebon, Garut, Indramayu, Karawang, Kuningan, Majalengka, Pangandaran, Purwakarta, Subang, Sukabumi, Sumedang, Tasikmalaya.
- **Kota (9):** Bandung, Banjar, Bekasi, Bogor, Cimahi, Cirebon, Depok, Sukabumi, Tasikmalaya.

Penamaan di tabel: `Kabupaten Bandung`, `Kota Bandung`, dan seterusnya.

### Jenis Lahan (8)

Laju dasar (meter per jam) adalah **nilai awal perkiraan**, bukan data ilmiah. Admin bisa mengubahnya di menu Jenis Lahan.

| No | Nama                              | Laju dasar | Keterangan singkat                                              |
| -- | --------------------------------- | ---------- | --------------------------------------------------------------- |
| 1  | Hutan Alam Pegunungan             | 150        | Hutan lebat taman nasional dan cagar alam, lembap                |
| 2  | Hutan Pinus Produksi              | 450        | Tegakan pinus, serasah kering mudah terbakar di musim kemarau    |
| 3  | Hutan Jati dan Mahoni             | 300        | Hutan produksi yang meranggas saat kemarau                       |
| 4  | Padang Rumput dan Alang-alang     | 700        | Lahan terbuka berumput, api merambat paling cepat                |
| 5  | Semak Belukar                     | 400        | Semak dan vegetasi rendah di lereng gunung                       |
| 6  | Kebun Teh dan Perkebunan          | 200        | Kebun teh, karet, dan perkebunan lain                            |
| 7  | Hutan Pantai dan Dataran Rendah   | 250        | Hutan di pesisir selatan dan dataran rendah                      |
| 8  | Hutan Mangrove                    | 100        | Hutan bakau pesisir, lembap dan berair                           |

### Kawasan Hutan (23)

Kolom **Lahan** merujuk nomor jenis lahan di atas. `Pengelola` untuk semua yang bertanda BBKSDA adalah Balai Besar KSDA Jawa Barat. Nama kabupaten/kota dihubungkan lewat tabel `kawasan_kabupaten`. Isi `deskripsi` dengan satu kalimat singkat (kategori, lokasi, dan ciri utama) dan sebutkan bahwa batas masih perkiraan.

| No | Nama                                         | Kategori           | Pengelola                              | Kabupaten/Kota                          | Lat    | Bujur   | Radius km | Luas ha   | Lahan |
| -- | -------------------------------------------- | ------------------ | -------------------------------------- | --------------------------------------- | ------ | ------- | --------- | --------- | ----- |
| 1  | Taman Nasional Gunung Gede Pangrango         | Taman Nasional     | Balai Besar TN Gunung Gede Pangrango   | Bogor, Cianjur, Sukabumi                | -6.78  | 106.98  | 8.8       | 24270.80  | 1     |
| 2  | Taman Nasional Gunung Halimun-Salak          | Taman Nasional     | Balai TN Gunung Halimun Salak          | Bogor, Sukabumi                         | -6.72  | 106.60  | 14        | -         | 1     |
| 3  | Taman Nasional Gunung Ciremai                | Taman Nasional     | Balai TN Gunung Ciremai                | Kuningan, Majalengka, Cirebon           | -6.89  | 108.40  | 7         | -         | 1     |
| 4  | Cagar Alam Gunung Simpang                    | Cagar Alam         | BBKSDA                                 | Bandung, Cianjur                        | -7.20  | 107.40  | 6.9       | 14756.20  | 1     |
| 5  | Cagar Alam Gunung Tilu                       | Cagar Alam         | BBKSDA                                 | Bandung                                 | -7.17  | 107.50  | 5         | 8000      | 1     |
| 6  | Cagar Alam Gunung Burangrang                 | Cagar Alam         | BBKSDA                                 | Purwakarta, Subang                      | -6.72  | 107.55  | 4         | -         | 1     |
| 7  | Gunung Tangkubanparahu (CA dan TWA)          | Taman Wisata Alam  | BBKSDA                                 | Bandung Barat, Subang                   | -6.76  | 107.61  | 3         | -         | 1     |
| 8  | Cagar Alam Junghuhn                          | Cagar Alam         | BBKSDA                                 | Bandung Barat                           | -6.80  | 107.62  | 1         | -         | 1     |
| 9  | Cagar Alam Leuweung Sancang                  | Cagar Alam         | BBKSDA                                 | Garut                                   | -7.72  | 107.80  | 6         | -         | 7     |
| 10 | Pananjung Pangandaran (CA dan TWA)           | Cagar Alam         | BBKSDA                                 | Pangandaran                             | -7.69  | 108.65  | 2         | -         | 7     |
| 11 | Suaka Margasatwa Gunung Sawal                | Suaka Margasatwa   | BBKSDA                                 | Ciamis                                  | -7.20  | 108.27  | 4         | -         | 1     |
| 12 | Suaka Margasatwa Cikepuh                     | Suaka Margasatwa   | BBKSDA                                 | Sukabumi                                | -7.35  | 106.45  | 8         | -         | 7     |
| 13 | Taman Wisata Alam Gunung Papandayan          | Taman Wisata Alam  | BBKSDA                                 | Garut, Bandung                          | -7.32  | 107.73  | 4         | -         | 5     |
| 14 | Taman Wisata Alam Kawah Kamojang             | Taman Wisata Alam  | BBKSDA                                 | Bandung, Garut                          | -7.14  | 107.79  | 3         | -         | 1     |
| 15 | Taman Wisata Alam Gunung Guntur              | Taman Wisata Alam  | BBKSDA                                 | Garut                                   | -7.14  | 107.84  | 3         | -         | 4     |
| 16 | Taman Wisata Alam Telaga Bodas               | Taman Wisata Alam  | BBKSDA                                 | Garut                                   | -7.20  | 107.97  | 1.5       | -         | 1     |
| 17 | Taman Wisata Alam Gunung Tampomas            | Taman Wisata Alam  | BBKSDA                                 | Sumedang                                | -6.77  | 107.95  | 4         | -         | 5     |
| 18 | Taman Wisata Alam Telaga Warna               | Taman Wisata Alam  | BBKSDA                                 | Bogor                                   | -6.70  | 107.00  | 1         | -         | 1     |
| 19 | Taman Wisata Alam Gunung Pancar              | Taman Wisata Alam  | BBKSDA                                 | Bogor                                   | -6.57  | 106.90  | 2         | -         | 2     |
| 20 | Taman Wisata Alam Linggarjati                | Taman Wisata Alam  | BBKSDA                                 | Kuningan                                | -6.90  | 108.48  | 1.5       | -         | 1     |
| 21 | Taman Buru Gunung Masigit Kareumbi           | Taman Buru         | BBKSDA                                 | Bandung, Garut, Sumedang                | -6.97  | 107.85  | 6         | -         | 1     |
| 22 | Taman Hutan Raya Ir. H. Djuanda              | Taman Hutan Raya   | Pemerintah Provinsi Jawa Barat         | Kota Bandung, Bandung Barat             | -6.86  | 107.63  | 2.5       | -         | 2     |
| 23 | Taman Hutan Raya Gunung Kunci dan Palasari   | Taman Hutan Raya   | (kosong)                               | Sumedang                                | -6.84  | 107.92  | 1.5       | -         | 5     |

Catatan untuk `deskripsi`:
- Gunung Papandayan dan Kawah Kamojang: BBKSDA pernah menurunkan status keduanya dari Cagar Alam menjadi Taman Wisata Alam, dan sebagian kawasan Papandayan masih tercatat sebagai Cagar Alam perluasan. Tuliskan bahwa status perlu diverifikasi.
- Gunung Tilu dan Gunung Simpang membentuk satu bentang alam pegunungan (Key Biodiversity Area Gunung Tilu-Simpang) dan terkenal sebagai habitat primata endemik Jawa.
- Luas Gunung Tilu "kurang lebih 8.000 ha" menurut BBKSDA Jawa Barat, sedangkan satu skripsi menyebut 7.478 ha. Pakai 8000 dan tandai sebagai perkiraan.
- Taman Nasional Gunung Halimun-Salak membentang di Jawa Barat dan Banten. Hanya kabupaten di Jawa Barat yang dihubungkan, dan luasnya dikosongkan karena angka resmi Jawa Barat saja belum dipastikan.
- Kawasan konservasi lain di Jawa Barat yang **belum diseed** karena koordinatnya belum terverifikasi: CA Telaga Patengan, Malabar, Cigenteng Cipanji, Dungus Iwul, Yan Lapa, Arca Domas, Takokak, Cadas Malang, Bojong Larang Jayanti, Sukawayana, Cibanteng, Gunung Jagat, Panjalu/Koorders; TWA Jember, Telaga Patengan, Cimanggu, Sukawayana; serta hutan lindung dan hutan produksi Perum Perhutani. Admin menambahkannya lewat menu Kawasan Hutan.

### Primata (5)

Semua status konservasi mengikuti IUCN Red List dan harus dicek ulang oleh admin. `Dilindungi` berarti termasuk satwa dilindungi menurut peraturan nasional.

| No | Nama Lokal                       | Nama Ilmiah             | Status | Dilindungi | Kawasan                                                                                                                                       |
| -- | -------------------------------- | ----------------------- | ------ | ---------- | --------------------------------------------------------------------------------------------------------------------------------------------- |
| 1  | Owa Jawa                         | Hylobates moloch        | EN     | Ya         | TN Gunung Gede Pangrango, TN Gunung Halimun-Salak, CA Gunung Tilu, CA Gunung Simpang                                                          |
| 2  | Surili                           | Presbytis comata        | EN     | Ya         | TN Gunung Gede Pangrango, TN Gunung Halimun-Salak, TN Gunung Ciremai, CA Gunung Burangrang, CA Gunung Tilu, TWA Kawah Kamojang, TWA Gunung Papandayan, TWA Gunung Tampomas |
| 3  | Lutung Jawa (Lutung Budeng)      | Trachypithecus auratus  | VU     | Ya         | TN Gunung Gede Pangrango, CA Gunung Tilu, CA Gunung Burangrang, Pananjung Pangandaran                                                         |
| 4  | Kukang Jawa                      | Nycticebus javanicus    | CR     | Ya         | TN Gunung Halimun-Salak, TN Gunung Gede Pangrango                                                                                              |
| 5  | Monyet Ekor Panjang              | Macaca fascicularis     | EN     | Tidak      | Pananjung Pangandaran, TWA Gunung Pancar, TN Gunung Gede Pangrango                                                                             |

Isi singkat untuk kolom `habitat`, `makanan`, `ciri_khas`, `deskripsi`:
- **Owa Jawa**: hutan hujan dataran rendah sampai pegunungan, hidup di tajuk pohon; makan buah, daun muda, bunga; tidak berekor, lengan panjang, bulu abu-abu keperakan, hidup berpasangan setia dan bersuara nyaring. Endemik Pulau Jawa.
- **Surili**: hutan pegunungan (di Gede Pangrango sekitar 700 sampai 1.500 mdpl), banyak beraktivitas di tajuk tengah sampai atas; makan daun muda, buah, bunga; punggung abu-abu gelap, perut putih, ada jambul di kepala. Sangat peka terhadap perubahan habitat.
- **Lutung Jawa**: hutan primer dan sekunder, kadang hutan pantai; makan daun muda dan buah; bulu hitam keabu-abuan, anak berwarna jingga.
- **Kukang Jawa**: aktif malam hari di hutan dan kebun; makan getah, serangga, buah; gerakan lambat, mata besar. Sering menjadi korban perdagangan satwa.
- **Monyet Ekor Panjang**: hutan pantai sampai kebun dekat permukiman; makan buah, biji, serangga, dan tanaman kebun; sering masuk kampung dan merusak kebun. Bukan satwa dilindungi menurut daftar nasional (cek peraturan terbaru), tetapi warga tetap diminta melapor ke petugas dan tidak menjerat atau menyakitinya.

Yang perlu dicek admin: sumber berbeda memberi status Lutung Jawa sebagai Rentan (VU) atau Terancam (EN), dan status Monyet Ekor Panjang diperbarui IUCN beberapa tahun terakhir. Sebaran kukang jawa dan monyet ekor panjang per kawasan masih perkiraan.

### Tumbuhan (10)

Status konservasi semua diisi `NE` (belum dinilai) dulu karena belum diverifikasi satu per satu; admin mengisinya dari IUCN Red List. `Dilindungi` hanya Rafflesia yang `Ya`.

| No | Nama Lokal                | Nama Ilmiah                 | Jenis   | Kawasan                                              |
| -- | ------------------------- | --------------------------- | ------- | ---------------------------------------------------- |
| 1  | Rasamala                  | Altingia excelsa            | Pohon   | TN Gunung Gede Pangrango, TN Gunung Halimun-Salak    |
| 2  | Puspa                     | Schima wallichii            | Pohon   | TN Gunung Gede Pangrango, TN Gunung Halimun-Salak, TN Gunung Ciremai |
| 3  | Edelweis Jawa             | Anaphalis javanica          | Perdu   | TN Gunung Gede Pangrango, TWA Gunung Papandayan, TN Gunung Ciremai |
| 4  | Kantong Semar             | Nepenthes spp.              | Lainnya | TN Gunung Gede Pangrango                             |
| 5  | Saninten                  | Castanopsis argentea        | Pohon   | TN Gunung Gede Pangrango, TN Gunung Halimun-Salak    |
| 6  | Jamuju                    | Dacrycarpus imbricatus      | Pohon   | TN Gunung Gede Pangrango                             |
| 7  | Anggrek Hutan             | Orchidaceae                 | Herba   | CA Gunung Tilu, TN Gunung Gede Pangrango             |
| 8  | Rafflesia                 | Rafflesia spp.              | Lainnya | CA Gunung Tilu, CA Gunung Simpang                    |
| 9  | Pinus (Tusam)             | Pinus merkusii              | Pohon   | TWA Gunung Pancar, Taman Hutan Raya Ir. H. Djuanda   |
| 10 | Bakau                     | Rhizophora spp.             | Pohon   | CA Leuweung Sancang                                  |

Isi `manfaat` dan `deskripsi` dengan satu atau dua kalimat umum (contoh: rasamala pohon raksasa penyusun hutan pegunungan dan kayunya dimanfaatkan; edelweis jawa tumbuh di padang di atas 2.000 mdpl dan tidak boleh dipetik; Rafflesia adalah bunga parasit langka yang dilindungi; pinus banyak ditanam di hutan produksi dan serasahnya mudah terbakar). Sebaran Edelweis di Papandayan dan Ciremai, serta Bakau di Sancang, masih perkiraan.

### Titik Penting (contoh demo)

Koordinat perkiraan untuk keperluan demo dan harus diganti admin dengan data lapangan. Titik Permukiman dipakai agar fitur Area Terancam di prediksi bisa langsung dicoba.

| No | Nama                                     | Jenis      | Lat     | Bujur    | Kabupaten/Kota | Kawasan                              |
| -- | ---------------------------------------- | ---------- | ------- | -------- | -------------- | ------------------------------------ |
| 1  | Pintu Masuk Cibodas (TNGGP)              | Pos Jaga   | -6.7460 | 107.0050 | Cianjur        | TN Gunung Gede Pangrango             |
| 2  | Pintu Masuk Palutungan (TNGC)            | Pos Jaga   | -6.9300 | 108.4350 | Kuningan       | TN Gunung Ciremai                    |
| 3  | Pintu Masuk Camp David Papandayan        | Pos Jaga   | -7.3190 | 107.7370 | Garut          | TWA Gunung Papandayan                |
| 4  | Pintu Masuk Tangkuban Parahu             | Pos Jaga   | -6.7600 | 107.6100 | (kosong)       | Gunung Tangkubanparahu (CA dan TWA)  |
| 5  | Permukiman Cibodas                       | Permukiman | -6.7400 | 107.0000 | Cianjur        | (kosong)                             |
| 6  | Permukiman Palutungan                    | Permukiman | -6.9400 | 108.4300 | Kuningan       | (kosong)                             |
| 7  | Permukiman Cisurupan                     | Permukiman | -7.3100 | 107.7600 | Garut          | (kosong)                             |

### Kontak Darurat

Hanya nomor yang sudah diverifikasi dari sumber publik. Admin menambahkan kontak BBKSDA Jawa Barat, balai taman nasional, Perum Perhutani, dan damkar/BPBD kabupaten setelah memastikan nomor resminya.

| Urutan | Nama                          | Instansi                | Nomor          | Keterangan                                   |
| ------ | ----------------------------- | ----------------------- | -------------- | -------------------------------------------- |
| 1      | Layanan Darurat Terpadu       | Layanan nasional        | 112            | Layanan darurat untuk semua jenis kejadian   |
| 2      | Pemadam Kebakaran             | Dinas Pemadam Kebakaran | 113            | Untuk kebakaran                              |
| 3      | Polisi                        | Polri                   | 110            | Untuk gangguan keamanan                      |
| 4      | BPBD Provinsi Jawa Barat      | BPBD                    | (022) 7313231  | Penanggulangan bencana tingkat provinsi      |

### Pengumuman Awal (kategori Tips Keselamatan, status Publish)

Tiga tulisan singkat dan umum, ditulis seperti pengumuman biasa:
1. Jangan membuang puntung rokok dan jangan membakar sampah atau lahan dekat hutan, terutama di musim kemarau.
2. Kalau melihat api di hutan: jauhi arah angin, jangan memadamkan sendiri kalau api sudah besar, segera lapor lewat aplikasi ini, dan hubungi 112 atau 113.
3. Bertemu satwa liar di kebun atau kampung: tetap tenang, jaga jarak, jangan memberi makan atau menjerat, dan laporkan lewat fitur Lapor Hewan Masuk Kampung.

### Sumber Riset Data Awal

- Perda Provinsi Jawa Barat Nomor 9 Tahun 2022 tentang RTRW Jawa Barat 2022-2042 (daftar kawasan konservasi, kabupaten letak kawasan, dan batas geografis wilayah).
- SK Dirjen PHKA Nomor 76 Tahun 2015 tentang Nomor Register Kawasan Suaka Alam, Kawasan Pelestarian Alam, dan Taman Buru.
- Situs Balai Besar KSDA Jawa Barat (publikasi kawasan konservasi dan buku "Anggrek Gunung Tilu").
- Key Biodiversity Areas dan BirdLife DataZone: Gunung Tilu-Simpang (titik pusat, flora penting).
- Berita dan jurnal: Mongabay Indonesia (status kawasan Kamojang dan Papandayan, surili, owa jawa), Kompas Lestari (daftar taman nasional dan cagar alam), Good News from Indonesia (sebaran surili), jurnal IPB dan UIN Sunan Gunung Djati (primata di Burangrang dan Gunung Tilu), Gridoto (nomor darurat Jawa Barat).

Semua angka dan nama di atas boleh dikoreksi admin lewat halaman admin tanpa mengubah kode.

## Livewire

Livewire 3 digunakan sebagai pengecualian khusus **HANYA untuk 3 hal: dropdown, pencarian, dan mode fullscreen**. Di luar tiga hal tersebut, tetap menggunakan Blade biasa dan JavaScript sederhana.

### Aturan Penggunaan Livewire
- Dilarang menulis direktif Alpine sendiri (`x-data`, `x-init`, dsb). Gunakan atribut `wire:`.
- Tetap patuhi aturan umum kode: **tanpa komentar di dalam kode**, kode sederhana tanpa computed property atau pola rumit, query Eloquent biasa, semua teks berbahasa Indonesia, tampilan Tailwind konsisten.
- Gunakan `wire:model.live.debounce.300ms` untuk input pencarian.
- Gunakan trait `WithPagination` dan panggil `resetPage()` saat nilai pencarian atau filter dropdown berubah.
- Tampilkan indikator teks "Memuat..." menggunakan `wire:loading`.
- Halaman Blade yang sudah ada hanya memanggil komponennya (`@livewire(...)` atau `<livewire:... />`) tanpa mengubah URL rute.
- **Form Lapor Darurat dan Cek Status DILARANG diubah ke Livewire** karena menggunakan mode offline (`localStorage`) dan rute pengecualian CSRF.

### Daftar Komponen

1. **Pencarian & Dropdown Publik:**
   - `PrimataIndex`: pencarian nama lokal dan nama ilmiah, dropdown Kabupaten/Kota, dropdown Kawasan bertingkat (mengikuti Kabupaten/Kota terpilih; reset ke semua kawasan jika Kabupaten/Kota dikosongkan).
   - `TumbuhanIndex`: sama seperti Primata, ditambah dropdown Jenis (Pohon, Perdu, Herba, Liana, Lainnya).

2. **Pencarian & Dropdown Admin:**
   - `LaporanTable`: pencarian kode dan deskripsi, dropdown Status, Jenis, dan Kabupaten/Kota.
   - Tabel CRUD Admin (`KawasanTable`, `TitikPentingTable`, `PrimataTable`, `TumbuhanTable`, `PengumumanTable`): pencarian nama (satu komponen per tabel). Tombol Edit tetap memakai atribut `data-*` dan modal JavaScript yang sudah ada, tombol Hapus tetap form dengan `@csrf`, `@method('DELETE')`, dan `confirm()`.

3. **Peta & Fullscreen:**
   - `PetaLayarPenuh` (reusable): menerima parameter `id` peta dan `tinggi`. Berisi pembungkus, tombol "Layar Penuh" / "Keluar Layar Penuh", dan div peta. Properti `$layarPenuh` diubah lewat tombol (saat `true` memakai kelas `fixed inset-0 z-50 bg-white`; saat `false` kelas normal). Div peta **WAJIB** memakai `wire:ignore` agar Leaflet tidak terganggu saat re-render. Setelah toggle, dispatch event ke browser untuk memanggil `peta.invalidateSize()`.
   - Dipasang pada: Peta Hutan (publik), Peringatan (publik), dan Prediksi Kebakaran (admin). Form prediksi admin tetap form biasa.
   - `PilihWilayah` (khusus Peta Hutan): dropdown Kabupaten/Kota dan Kawasan bertingkat. Saat kawasan dipilih, kirim event (`lat_pusat`, `long_pusat`, `zoom`) agar peta terbang (`flyTo`) ke lokasi. Zoom ditentukan dengan `if/else` dari radius kawasan (<= 2 km: zoom 13, <= 5 km: zoom 12, <= 9 km: zoom 11, selain itu: zoom 10). Jika Kabupaten/Kota dipilih tanpa kawasan, saring daftar kawasan di dropdown sesuai kabupaten tersebut.

## Keamanan

- Password disimpan dengan `Hash::make`, tidak pernah ditampilkan atau dicatat di log.
- Semua route `/admin/...` dijaga middleware `auth`, bukan hanya menyembunyikan menu.
- Nomor HP dan nama pelapor, serta IP pelapor, hanya tampil di halaman admin.
- Kode laporan acak, tidak berurutan, dan cek status dibatasi throttle supaya tidak bisa ditebak.
- Laporan dari publik tidak langsung dipercaya: harus diverifikasi admin dulu sebelum tampil di peta publik.
- `FIRMS_MAP_KEY` hanya ada di `.env` dan hanya dipakai di server.
- File `.env` tidak ikut di-commit.

## Urutan Pengerjaan Modul

Kerjakan bertahap sesuai fase PRD. Setelah tiap tahap, pastikan project bisa dijalankan (`php artisan serve`) tanpa error sebelum lanjut.

1. **Fondasi**: install Laravel, atur `.env`, timezone dan locale, semua migration + model, semua seeder (akun admin, `pengaturan_hutan`, dan seluruh data awal di bagian "Data Awal Jawa Barat (Seeder)"), `storage:link`.
2. **Fase 1, login dan kerangka**: `LoginController` (termasuk halaman Lupa Kata Sandi berisi petunjuk), middleware `auth`, layout publik dan admin, `partials/modal-pesan`, dashboard admin kosong.
3. **Fase 1, peta**: Pengaturan, Jenis Lahan, Kawasan Hutan (gambar poligon), Titik Penting, lalu halaman publik Peta Hutan dan Beranda sederhana.
4. **Fase 2, lapor darurat**: form lapor (GPS + pilih di peta), halaman sukses dengan kode, Cek Status, mode offline (`localStorage`), throttle, lalu **Kelola Laporan** di admin. Tahap ini dahulukan Lapor Hewan Masuk Kampung, lalu Kebakaran.
5. **Fase 3, prediksi**: Ambil Titik Api Satelit (FIRMS), Ambil Data Cuaca (Open-Meteo), hitung elips, area terancam, riwayat prediksi, Tampil Publik, halaman publik Peringatan.
6. **Fase 3, data satwa dan tumbuhan**: CRUD Primata dan Tumbuhan, halaman publik daftar dan detail, filter kawasan.
7. **Fase 4, info hutan**: Pengumuman, Jadwal Patroli, Kontak Darurat, halaman publik Info Hutan.
8. **Fase 4, penutup**: Dashboard Admin (statistik, grafik batang, kawasan rawan), Pengaturan Tampilan di publik (pilihan ukuran huruf kecil/normal/besar dan mode gelap, disimpan di `localStorage`, hanya mengubah ukuran dan warna dasar halaman), Akun Admin, rapikan tampilan HP.

## Catatan Penting

- Struktur tabel hanya lewat migration. Kalau perlu kolom baru, buat migration baru, jangan ubah migration lama yang sudah dijalankan.
- Semua teks, pesan, dan label dalam Bahasa Indonesia.
- Konten (pengumuman, primata, tumbuhan, deskripsi kawasan) diisi lewat halaman admin, jangan ditulis langsung di Blade.
- Tailwind lewat CDN cukup untuk project sekolah dan development. Kalau nanti dipublikasikan sungguhan, tanyakan dulu apakah mau diganti ke build Tailwind.
- Tile OpenStreetMap punya ketentuan pemakaian untuk lalu lintas besar. Kalau nanti dipakai sungguhan oleh banyak orang, tanyakan dulu apakah mau diganti penyedia tile lain.
- **Belum dikerjakan (ditunda, jangan ditambahkan kecuali diminta):** login warga, role petugas, notifikasi WhatsApp/SMS/email ke petugas, jenis laporan lain (pembalakan liar, perburuan, longsor), PWA dan service worker, reset kata sandi lewat email, kemiringan lereng dan elevasi, peta satelit, impor batas kawasan resmi, machine learning, pengambilan titik api otomatis terjadwal, ekspor Excel, multi-bahasa, aplikasi mobile. Wilayah di luar Jawa Barat (Banten, DKI Jakarta, Jawa Tengah, dan provinsi lain), serta impor batas kawasan resmi dari data pemerintah.