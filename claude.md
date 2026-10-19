# Jaga Hutan Desa

Website pengelolaan hutan untuk desa di sekitar kawasan hutan: peta kawasan dan titik penting, laporan darurat dari warga (kebakaran dan hewan masuk kampung) tanpa login, pantauan status laporan, prediksi arah sebaran kebakaran, data primata dan tumbuhan, serta informasi hutan. Dibangun dengan Laravel dan MySQL. Hanya ada **1 role: Admin**. Warga (publik) **tidak punya akun dan tidak login**.

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
10. Tampilan memakai **Blade + Tailwind CSS (CDN) + Font Awesome**. Tidak memakai Livewire, Inertia, Vue, React, atau Alpine. JavaScript ditulis sederhana dalam bentuk fungsi biasa (`bukaModal`, `tutupModal`, `kirimLaporan`, dst).
11. Library tambahan yang diizinkan hanya: **Leaflet** dan **Leaflet.draw** (peta dan gambar poligon), keduanya lewat CDN cdnjs. Pemanggilan API luar memakai `Http` bawaan Laravel (bukan package Composer tambahan). Library atau package lain tanya dulu.
12. Fitur yang tidak ada di `CLAUDE.md` ini tidak boleh ditambahkan hanya karena ada di PRD atau terpikir bagus. Kalau ragu, tanya dulu.

Aturan ini berlaku untuk semua perubahan berikutnya, tanpa perlu diingatkan lagi.

## Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
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
│   └── Models/                             satu model per tabel
├── database/
│   ├── migrations/
│   └── seeders/                            DatabaseSeeder (akun admin, pengaturan_hutan, jenis_lahan, kontak_darurat, data contoh)
├── resources/views/
│   ├── layouts/                            publik.blade.php, admin.blade.php (sidebar)
│   ├── partials/                           modal-pesan.blade.php
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

**Badge status konservasi (primata dan tumbuhan):** Kritis (CR) `bg-red-100 text-red-800`, Terancam (EN) `bg-orange-100 text-orange-800`, Rentan (VU) `bg-yellow-100 text-yellow-800`, Hampir Terancam (NT) `bg-lime-100 text-lime-800`, Risiko Rendah (LC) `bg-green-100 text-green-800`, Data Kurang (DD) `bg-stone-100 text-stone-700`.

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
- **Peta Hutan** (`/peta`): peta Leaflet layar penuh. Isi: poligon kawasan hutan, titik penting, dan laporan yang statusnya **Diverifikasi, Ditangani** (laporan Baru dan Selesai tidak ditampilkan di peta publik). Ada kotak centang untuk menyalakan atau mematikan tiap lapisan (Kawasan, Titik Penting, Laporan). Klik poligon atau marker membuka popup **Detail Titik**: nama, jenis, deskripsi, foto, dan kontak. Nomor HP pelapor dan nama pelapor **tidak pernah** ditampilkan di halaman publik.
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
- Lokasi: tombol **Gunakan Lokasi Saya** (GPS otomatis) dan peta kecil untuk menunjuk lokasi manual. Latitude dan longitude terisi dari salah satunya. Laporan tidak bisa dikirim tanpa lokasi.
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
- Validasi: jenis harus salah satu dari dua pilihan, latitude `between:-90,90`, longitude `between:-180,180`, deskripsi maksimal 1000 karakter, foto `image|mimes:jpg,jpeg,png|max:5120`, nomor HP hanya angka dan tanda `+`, maksimal 20 karakter.
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

**Dashboard**: kartu statistik (laporan Baru, kebakaran aktif, hewan masuk kampung bulan ini, jumlah kawasan, primata, tumbuhan); **grafik batang sederhana** laporan per bulan untuk 6 bulan terakhir (dibuat dengan `div` Tailwind berlebar persen, tanpa library grafik); daftar **Kawasan Paling Rawan** (jumlah laporan kebakaran per kawasan, 5 teratas); dan 5 laporan terbaru. Dashboard dikerjakan paling akhir karena merangkum semua modul.

**A. Kawasan Hutan**: tabel Nama, Jenis Lahan, Luas (ha), Aksi. Halaman Tambah/Edit berisi peta Leaflet dengan **Leaflet.draw** (hanya alat gambar poligon, satu poligon per kawasan). Hasil gambar disimpan sebagai **GeoJSON** di kolom `geojson`. Field: Nama, Deskripsi, Jenis Lahan (dropdown dari tabel `jenis_lahan`), Luas (opsional). Primata dan tumbuhan yang ada di kawasan ini dipilih dari halaman Primata dan Tumbuhan, bukan di sini.

**B. Titik Penting**: tabel Nama, Jenis, Kawasan, Aksi. Halaman Tambah/Edit: peta, klik peta untuk menaruh titik (latitude dan longitude terisi otomatis). Field: Nama, Jenis (**Pos Jaga, Pos Pemadam, Sumber Air, Titik Kumpul Evakuasi, Permukiman**), Deskripsi, Foto (upload, opsional), Kontak (opsional), Kawasan (dropdown, opsional). Titik berjenis **Permukiman** dipakai untuk Peringatan Area Terancam.

**C. Kelola Laporan**: tabel Kode, Jenis, Waktu, Lokasi, Status (badge), Aksi, dengan filter status dan jenis, urut terbaru, pagination 10. Halaman detail laporan menampilkan peta kecil dengan lokasi, foto, deskripsi, nama dan nomor HP pelapor (hanya admin), serta form: **Status** (Baru, Diverifikasi, Ditangani, Selesai), **Kawasan** (dropdown), **Catatan Admin** (tampil ke warga di Cek Status). Tombol **Hitung Prediksi dari Titik Ini** (hanya untuk laporan Kebakaran) membuka halaman Prediksi dengan lokasi terisi. Laporan bisa dihapus (dengan konfirmasi), misalnya untuk laporan palsu.

**D. Prediksi Kebakaran**: lihat bagian Prediksi Kebakaran di bawah.

**E. Primata**: tabel Foto, Nama Lokal, Nama Ilmiah, Status Konservasi (badge), Dilindungi, Aksi. Modal: Nama Lokal, Nama Ilmiah, Status Konservasi (CR/EN/VU/NT/LC/DD), Dilindungi (checkbox), Habitat, Makanan, Ciri Khas, Deskripsi, Foto (upload), **Kawasan** (kotak centang beberapa kawasan).

**F. Tumbuhan**: sama seperti Primata, dengan Jenis (Pohon/Perdu/Herba/Liana/Lainnya) dan Manfaat sebagai pengganti Makanan dan Ciri Khas.

**G. Pengumuman**: tabel Judul, Kategori, Tanggal, Status, Aksi. Modal: Judul, Kategori (**Kabar, Pengumuman, Tips Keselamatan**), Isi, Gambar (upload, opsional), Status (Draft/Publish).

**H. Jadwal Patroli**: modal berisi Judul Kegiatan, Tanggal, Jam, Lokasi, Keterangan. Tampil di Info Hutan, yang sudah lewat tidak ditampilkan di publik tapi tetap ada di admin.

**I. Kontak Darurat**: modal berisi Nama, Instansi, Nomor Telepon, Keterangan, Urutan tampil.

**J. Jenis Lahan**: modal berisi Nama, **Laju Dasar Api (meter per jam)**, Keterangan. Dipakai sebagai faktor prediksi. Seeder mengisi nilai awal (lihat bagian Prediksi).

**K. Akun Admin**: tabel Nama, Username, Status, Aksi. Modal: Nama, Username (unik, huruf kecil), Password (wajib saat Tambah, saat Edit kosong berarti tidak diganti), Status. Akun yang sedang login tidak boleh dihapus, dan tidak boleh menonaktifkan diri sendiri.

**L. Pengaturan**: form berisi Nama Aplikasi, Nama Instansi, Slogan, Deskripsi Singkat, Alamat, Email, Telepon, Logo (upload), serta **Pengaturan Peta**: Latitude Pusat, Longitude Pusat, Zoom Awal, dan **Radius Pencarian Titik Api (km)**. Tombol **Simpan Perubahan**.

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

**Titik api satelit (NASA FIRMS).** Tombol Ambil Titik Api Satelit memanggil API area CSV FIRMS dengan kotak area di sekitar Latitude/Longitude Pusat sejauh `radius_titik_api_km` (derajat = km / 111), 1 hari terakhir. Hasil CSV diurai dengan `str_getcsv` dan disimpan ke `titik_api` (lewati yang sudah ada). Agar tidak membebani API, jangan memanggil lagi kalau `terakhir_ambil_firms` di `pengaturan_hutan` masih kurang dari 30 menit; tampilkan pesan "Data baru saja diambil." Kalau `FIRMS_MAP_KEY` kosong, tampilkan pesan bahwa kunci belum diisi.

**Rumus perkiraan** (model elips sederhana, bukan simulasi grid, supaya kode lurus). Semua angka di bawah adalah **nilai awal perkiraan, bukan data ilmiah**, dan bisa diubah di Jenis Lahan atau di controller:

```
lajuEfektif = lajuDasar * (1 + kecepatanAngin / 10) * faktorKelembapan * faktorHujan
```

- `lajuDasar`: dari `jenis_lahan.laju_dasar` (meter per jam). Nilai awal seeder: Hutan Lebat 150, Semak Belukar 400, Alang-alang/Padang Rumput 700, Kebun 250, Lahan Gambut 200.
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
Satu baris saja (id selalu 1): `nama_aplikasi`, `nama_instansi`, `slogan`, `deskripsi_singkat`, `alamat`, `email`, `telepon`, `logo`, `lat_pusat`, `long_pusat`, `zoom_awal` (default 12), `radius_titik_api_km` (default 30), `terakhir_ambil_firms` (datetime, nullable).

### jenis_lahan
`id`, `nama` (unik), `laju_dasar` (INT, meter per jam), `keterangan` (nullable).

### kawasan_hutan
`id`, `nama`, `deskripsi`, `luas_ha` (nullable), `geojson` (longText), `id_jenis_lahan` (FK).

### titik_penting
`id`, `nama`, `jenis` (`Pos Jaga` / `Pos Pemadam` / `Sumber Air` / `Titik Kumpul Evakuasi` / `Permukiman`), `latitude`, `longitude`, `deskripsi`, `foto` (nullable), `kontak` (nullable), `id_kawasan` (nullable, FK).

### laporan
`id`, `kode` (unik), `jenis` (`Kebakaran` / `Hewan Masuk Kampung`), `jenis_hewan` (nullable), `latitude`, `longitude`, `deskripsi`, `foto` (nullable), `nama_pelapor` (nullable), `no_hp` (nullable), `status` (default `Baru`), `catatan_admin` (nullable), `id_kawasan` (nullable, FK), `id_admin` (nullable, FK `users`, admin yang terakhir mengubah), `ip_pelapor`, timestamps.

### titik_api
`id`, `latitude`, `longitude`, `tanggal_deteksi` (DATE), `waktu_deteksi` (string), `kepercayaan` (string), `sumber` (default `VIIRS`), timestamps. Kombinasi `latitude` + `longitude` + `tanggal_deteksi` + `waktu_deteksi` **unik**.

### prediksi_api
`id`, `id_laporan` (nullable, FK), `latitude`, `longitude`, `id_jenis_lahan` (FK), `arah_angin`, `kecepatan_angin`, `kelembapan`, `curah_hujan` (semua angka desimal), `laju_efektif`, `poligon_1jam`, `poligon_3jam`, `poligon_6jam` (longText, JSON titik), `luas_1jam`, `luas_3jam`, `luas_6jam` (desimal, ha), `area_terancam` (text, JSON), `tampil_publik` (boolean, default 0), `id_admin` (FK `users`), timestamps.

### primata
`id`, `nama_lokal`, `nama_ilmiah`, `status_konservasi` (`CR` / `EN` / `VU` / `NT` / `LC` / `DD`), `dilindungi` (boolean), `habitat`, `makanan`, `ciri_khas`, `deskripsi`, `foto` (nullable).

### tumbuhan
`id`, `nama_lokal`, `nama_ilmiah`, `jenis` (`Pohon` / `Perdu` / `Herba` / `Liana` / `Lainnya`), `status_konservasi`, `dilindungi` (boolean), `manfaat`, `deskripsi`, `foto` (nullable).

### kawasan_primata dan kawasan_tumbuhan
Tabel penghubung: `id_kawasan` (FK), `id_primata` atau `id_tumbuhan` (FK). Relasi `belongsToMany` biasa di model.

### pengumuman
`id`, `judul`, `kategori` (`Kabar` / `Pengumuman` / `Tips Keselamatan`), `isi`, `gambar` (nullable), `tanggal`, `status` (default `Draft`), `id_user`, timestamps.

### jadwal_patroli
`id`, `judul`, `tanggal` (DATE), `jam`, `lokasi`, `keterangan` (nullable).

### kontak_darurat
`id`, `nama`, `instansi`, `nomor_telepon`, `keterangan` (nullable), `urutan` (INT, default 0).

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

1. **Fondasi**: install Laravel, atur `.env`, timezone dan locale, semua migration + model, seeder (akun admin, `pengaturan_hutan`, `jenis_lahan`, `kontak_darurat`, data contoh), `storage:link`.
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
- **Belum dikerjakan (ditunda, jangan ditambahkan kecuali diminta):** login warga, role petugas, notifikasi WhatsApp/SMS/email ke petugas, jenis laporan lain (pembalakan liar, perburuan, longsor), PWA dan service worker, reset kata sandi lewat email, kemiringan lereng dan elevasi, peta satelit, impor batas kawasan resmi, machine learning, pengambilan titik api otomatis terjadwal, ekspor Excel, multi-bahasa, aplikasi mobile.