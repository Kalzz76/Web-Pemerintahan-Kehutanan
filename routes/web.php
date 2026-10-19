<?php

use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalPatroliController;
use App\Http\Controllers\Admin\JenisLahanController;
use App\Http\Controllers\Admin\KawasanController;
use App\Http\Controllers\Admin\KontakDaruratController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PrediksiController;
use App\Http\Controllers\Admin\PrimataController;
use App\Http\Controllers\Admin\TitikPentingController;
use App\Http\Controllers\Admin\TumbuhanController;
use App\Http\Controllers\LaporController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PublikController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublikController::class, 'beranda'])->name('beranda');
Route::get('/peta', [PublikController::class, 'peta'])->name('peta');
Route::get('/peringatan', [PublikController::class, 'peringatan'])->name('peringatan');
Route::get('/primata', [PublikController::class, 'primata'])->name('primata');
Route::get('/primata/{id}', [PublikController::class, 'detailPrimata'])->name('primata.detail');
Route::get('/tumbuhan', [PublikController::class, 'tumbuhan'])->name('tumbuhan');
Route::get('/tumbuhan/{id}', [PublikController::class, 'detailTumbuhan'])->name('tumbuhan.detail');
Route::get('/info', [PublikController::class, 'info'])->name('info');

Route::get('/lapor', [LaporController::class, 'index'])->name('lapor');
Route::post('/lapor', [LaporController::class, 'simpan'])->name('lapor.simpan')->middleware('throttle:5,60');
Route::post('/lapor/sinkron', [LaporController::class, 'sinkron'])->name('lapor.sinkron')->middleware('throttle:5,60');
Route::get('/lapor/status', [LaporController::class, 'status'])->name('lapor.status')->middleware('throttle:20,1');
Route::post('/lapor/status', [LaporController::class, 'status'])->name('lapor.status.post')->middleware('throttle:20,1');

Route::get('/login', [LoginController::class, 'tampilLogin'])->name('login');
Route::post('/login', [LoginController::class, 'prosesLogin'])->name('login.proses');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/lupa-password', [LoginController::class, 'tampilLupaPassword'])->name('lupa-password');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/kawasan', [KawasanController::class, 'index'])->name('kawasan.index');
    Route::get('/kawasan/tambah', [KawasanController::class, 'create'])->name('kawasan.create');
    Route::post('/kawasan', [KawasanController::class, 'store'])->name('kawasan.store');
    Route::get('/kawasan/{id}/edit', [KawasanController::class, 'edit'])->name('kawasan.edit');
    Route::put('/kawasan/{id}', [KawasanController::class, 'update'])->name('kawasan.update');
    Route::delete('/kawasan/{id}', [KawasanController::class, 'destroy'])->name('kawasan.destroy');

    Route::get('/titik-penting', [TitikPentingController::class, 'index'])->name('titik-penting.index');
    Route::get('/titik-penting/tambah', [TitikPentingController::class, 'create'])->name('titik-penting.create');
    Route::post('/titik-penting', [TitikPentingController::class, 'store'])->name('titik-penting.store');
    Route::get('/titik-penting/{id}/edit', [TitikPentingController::class, 'edit'])->name('titik-penting.edit');
    Route::put('/titik-penting/{id}', [TitikPentingController::class, 'update'])->name('titik-penting.update');
    Route::delete('/titik-penting/{id}', [TitikPentingController::class, 'destroy'])->name('titik-penting.destroy');

    Route::get('/jenis-lahan', [JenisLahanController::class, 'index'])->name('jenis-lahan.index');
    Route::post('/jenis-lahan', [JenisLahanController::class, 'store'])->name('jenis-lahan.store');
    Route::put('/jenis-lahan/{id}', [JenisLahanController::class, 'update'])->name('jenis-lahan.update');
    Route::delete('/jenis-lahan/{id}', [JenisLahanController::class, 'destroy'])->name('jenis-lahan.destroy');

    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [AdminLaporanController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{id}', [AdminLaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [AdminLaporanController::class, 'destroy'])->name('laporan.destroy');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::post('/prediksi/ambil-satelit', [PrediksiController::class, 'ambilTitikApi'])->name('prediksi.ambil-satelit');
    Route::post('/prediksi/ambil-cuaca', [PrediksiController::class, 'ambilCuaca'])->name('prediksi.ambil-cuaca');
    Route::post('/prediksi/hitung', [PrediksiController::class, 'hitung'])->name('prediksi.hitung');
    Route::post('/prediksi/{id}/toggle-publik', [PrediksiController::class, 'togglePublik'])->name('prediksi.toggle-publik');
    Route::delete('/prediksi/{id}', [PrediksiController::class, 'destroy'])->name('prediksi.destroy');

    Route::get('/primata', [PrimataController::class, 'index'])->name('primata.index');
    Route::post('/primata', [PrimataController::class, 'store'])->name('primata.store');
    Route::put('/primata/{id}', [PrimataController::class, 'update'])->name('primata.update');
    Route::delete('/primata/{id}', [PrimataController::class, 'destroy'])->name('primata.destroy');

    Route::get('/tumbuhan', [TumbuhanController::class, 'index'])->name('tumbuhan.index');
    Route::post('/tumbuhan', [TumbuhanController::class, 'store'])->name('tumbuhan.store');
    Route::put('/tumbuhan/{id}', [TumbuhanController::class, 'update'])->name('tumbuhan.update');
    Route::delete('/tumbuhan/{id}', [TumbuhanController::class, 'destroy'])->name('tumbuhan.destroy');

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{id}', [PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

    Route::get('/jadwal-patroli', [JadwalPatroliController::class, 'index'])->name('jadwal-patroli.index');
    Route::post('/jadwal-patroli', [JadwalPatroliController::class, 'store'])->name('jadwal-patroli.store');
    Route::put('/jadwal-patroli/{id}', [JadwalPatroliController::class, 'update'])->name('jadwal-patroli.update');
    Route::delete('/jadwal-patroli/{id}', [JadwalPatroliController::class, 'destroy'])->name('jadwal-patroli.destroy');

    Route::get('/kontak-darurat', [KontakDaruratController::class, 'index'])->name('kontak-darurat.index');
    Route::post('/kontak-darurat', [KontakDaruratController::class, 'store'])->name('kontak-darurat.store');
    Route::put('/kontak-darurat/{id}', [KontakDaruratController::class, 'update'])->name('kontak-darurat.update');
    Route::delete('/kontak-darurat/{id}', [KontakDaruratController::class, 'destroy'])->name('kontak-darurat.destroy');

    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');
});
