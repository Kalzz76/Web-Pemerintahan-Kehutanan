<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLahan;
use App\Models\KawasanHutan;
use App\Models\Laporan;
use App\Models\PengaturanHutan;
use App\Models\PrediksiApi;
use App\Models\TitikApi;
use App\Models\TitikPenting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PrediksiController extends Controller
{
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

    public function index(Request $request)
    {
        $pengaturan = PengaturanHutan::first();
        $daftarKawasan = KawasanHutan::select('id', 'nama', 'geojson')->get();
        $daftarPermukiman = TitikPenting::where('jenis', 'Permukiman')->get();
        $daftarTitikApi = TitikApi::latest('tanggal_deteksi')->take(50)->get();
        $daftarKebakaranAktif = Laporan::where('jenis', 'Kebakaran')
            ->whereIn('status', ['Baru', 'Diverifikasi', 'Ditangani'])
            ->get();
        $daftarJenisLahan = JenisLahan::orderBy('nama')->get();
        $riwayatPrediksi = PrediksiApi::with(['laporan', 'jenisLahan', 'admin'])->latest()->paginate(10)->withQueryString();

        $idPrediksiAktif = $request->query('id_prediksi');
        $prediksiAktif = null;
        if ($idPrediksiAktif) {
            $prediksiAktif = PrediksiApi::with(['laporan', 'jenisLahan'])->find($idPrediksiAktif);
        }

        $inputLat = $request->query('lat');
        $inputLong = $request->query('long');
        $inputIdLaporan = $request->query('id_laporan');

        return view('admin.prediksi.index', compact(
            'pengaturan',
            'daftarKawasan',
            'daftarPermukiman',
            'daftarTitikApi',
            'daftarKebakaranAktif',
            'daftarJenisLahan',
            'riwayatPrediksi',
            'prediksiAktif',
            'inputLat',
            'inputLong',
            'inputIdLaporan'
        ));
    }

    public function ambilCuaca(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        try {
            $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'current' => 'temperature_2m,relative_humidity_2m,precipitation,wind_speed_10m,wind_direction_10m',
                'wind_speed_unit' => 'kmh',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['current'])) {
                    $cur = $data['current'];
                    return response()->json([
                        'sukses' => true,
                        'suhu' => $cur['temperature_2m'] ?? null,
                        'kelembapan' => $cur['relative_humidity_2m'] ?? null,
                        'curah_hujan' => $cur['precipitation'] ?? 0,
                        'kecepatan_angin' => $cur['wind_speed_10m'] ?? null,
                        'arah_angin' => $cur['wind_direction_10m'] ?? null,
                    ]);
                }
            }

            return response()->json([
                'sukses' => false,
                'pesan' => 'Layanan Open-Meteo tidak memberikan data cuaca lengkap. Silakan isi parameter cuaca secara manual.',
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Koneksi ke Open-Meteo gagal atau batas waktu habis. Silakan isi parameter cuaca secara manual.',
            ], 422);
        }
    }

    public function ambilTitikApi()
    {
        $pengaturan = PengaturanHutan::first();
        if (!$pengaturan) {
            return redirect()->route('admin.prediksi.index')->with('error', 'Data pengaturan hutan belum tersedia.');
        }

        $firmsKey = config('services.firms.map_key');
        if (empty($firmsKey)) {
            return redirect()->route('admin.prediksi.index')->with('error', 'Kunci API NASA FIRMS (FIRMS_MAP_KEY) belum diisi di konfigurasi .env.');
        }

        if ($pengaturan->terakhir_ambil_firms) {
            $selisihMenit = Carbon::parse($pengaturan->terakhir_ambil_firms)->diffInMinutes(now());
            if ($selisihMenit < 30) {
                return redirect()->route('admin.prediksi.index')->with('info', 'Data baru saja diambil. Mohon tunggu jeda 30 menit sebelum mengambil kembali.');
            }
        }

        $west = round($pengaturan->bbox_barat ?? 106.36, 3);
        $south = round($pengaturan->bbox_selatan ?? -7.83, 3);
        $east = round($pengaturan->bbox_timur ?? 108.85, 3);
        $north = round($pengaturan->bbox_utara ?? -5.90, 3);

        $url = "https://firms.modaps.eosdis.nasa.gov/api/area/csv/{$firmsKey}/VIIRS_SNPP_NRT/{$west},{$south},{$east},{$north}/1";

        try {
            $response = Http::timeout(15)->get($url);
            if ($response->successful()) {
                $body = trim($response->body());
                $lines = explode("\n", $body);

                if (count($lines) < 2) {
                    $pengaturan->terakhir_ambil_firms = now();
                    $pengaturan->save();
                    return redirect()->route('admin.prediksi.index')->with('info', 'Pemeriksaan satelit selesai: Tidak ada titik api satelit aktif terdeteksi di wilayah Jawa Barat.');
                }

                $header = str_getcsv(array_shift($lines));
                $latIndex = array_search('latitude', $header);
                $lonIndex = array_search('longitude', $header);
                $dateIndex = array_search('acq_date', $header);
                $timeIndex = array_search('acq_time', $header);
                $confIndex = array_search('confidence', $header);

                $jumlahBaru = 0;
                foreach ($lines as $line) {
                    $baris = str_getcsv($line);
                    if (count($baris) < count($header)) continue;

                    $lat = floatval($baris[$latIndex]);
                    $lon = floatval($baris[$lonIndex]);
                    $tanggal = $baris[$dateIndex];
                    $waktu = $baris[$timeIndex];
                    $conf = $confIndex !== false ? $baris[$confIndex] : 'nominal';

                    $sudahAda = TitikApi::where('latitude', $lat)
                        ->where('longitude', $lon)
                        ->where('tanggal_deteksi', $tanggal)
                        ->where('waktu_deteksi', $waktu)
                        ->exists();

                    if (!$sudahAda) {
                        TitikApi::create([
                            'latitude' => $lat,
                            'longitude' => $lon,
                            'tanggal_deteksi' => $tanggal,
                            'waktu_deteksi' => $waktu,
                            'kepercayaan' => $conf,
                            'sumber' => 'VIIRS',
                        ]);
                        $jumlahBaru++;
                    }
                }

                $pengaturan->terakhir_ambil_firms = now();
                $pengaturan->save();

                return redirect()->route('admin.prediksi.index')->with('sukses', 'Berhasil memperbarui data satelit. Ditemukan ' . $jumlahBaru . ' titik api satelit baru.');
            }

            return redirect()->route('admin.prediksi.index')->with('error', 'Gagal mengambil data dari server NASA FIRMS. Periksa kembali kunci API dan kuota akses.');
        } catch (\Exception $e) {
            return redirect()->route('admin.prediksi.index')->with('error', 'Gagal menghubungi server NASA FIRMS: ' . $e->getMessage());
        }
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'id_jenis_lahan' => 'required|exists:jenis_lahan,id',
            'arah_angin' => 'required|numeric|between:0,360',
            'kecepatan_angin' => 'required|numeric|min:0',
            'kelembapan' => 'required|numeric|between:0,100',
            'curah_hujan' => 'required|numeric|min:0',
            'id_laporan' => 'nullable|exists:laporan,id',
        ], [
            'latitude.required' => 'Koordinat latitude titik api wajib ditentukan.',
            'longitude.required' => 'Koordinat longitude titik api wajib ditentukan.',
            'id_jenis_lahan.required' => 'Jenis lahan awal perambatan wajib dipilih.',
            'arah_angin.required' => 'Arah mata angin wajib diisi.',
            'kecepatan_angin.required' => 'Kecepatan angin wajib diisi.',
            'kelembapan.required' => 'Kelembapan udara wajib diisi.',
            'curah_hujan.required' => 'Curah hujan wajib diisi.',
        ]);

        $lat = floatval($request->latitude);
        $long = floatval($request->longitude);
        $jenisLahan = JenisLahan::findOrFail($request->id_jenis_lahan);
        $kecepatanAngin = floatval($request->kecepatan_angin);
        $arahAngin = floatval($request->arah_angin);
        $kelembapan = floatval($request->kelembapan);
        $curahHujan = floatval($request->curah_hujan);

        $faktorKelembapan = 1.0;
        if ($kelembapan >= 80) {
            $faktorKelembapan = 0.5;
        } elseif ($kelembapan >= 60) {
            $faktorKelembapan = 0.8;
        } elseif ($kelembapan >= 40) {
            $faktorKelembapan = 1.0;
        } else {
            $faktorKelembapan = 1.3;
        }

        $faktorHujan = ($curahHujan > 0) ? 0.3 : 1.0;

        $lajuEfektif = $jenisLahan->laju_dasar * (1 + $kecepatanAngin / 10) * $faktorKelembapan * $faktorHujan;

        $arahRambat = fmod(($arahAngin + 180), 360);
        $rasio = min(4, 1 + $kecepatanAngin / 10);

        $poligonHasil = [];
        $luasHasil = [];

        foreach ([1, 3, 6] as $j) {
            $depan = $lajuEfektif * $j;
            $belakang = $depan * 0.2;
            $a = ($depan + $belakang) / 2;
            $geser = ($depan - $belakang) / 2;
            $b = $a / $rasio;

            $luasHa = (M_PI * $a * $b) / 10000;
            $luasHasil[$j] = round($luasHa, 2);

            $titik = $this->hitungElips($lat, $long, $arahRambat, $a, $b, $geser);
            $poligonHasil[$j] = $titik;
        }

        $areaTerancam = [];
        $daftarPermukiman = TitikPenting::where('jenis', 'Permukiman')->get();
        $sudutRambat = deg2rad($arahRambat);

        foreach ($daftarPermukiman as $permukiman) {
            $utara = ($permukiman->latitude - $lat) * 111320;
            $timur = ($permukiman->longitude - $long) * 111320 * cos(deg2rad($lat));
            $u = $timur * sin($sudutRambat) + $utara * cos($sudutRambat);
            $v = $timur * cos($sudutRambat) - $utara * sin($sudutRambat);

            $jamKena = null;
            foreach ([1, 3, 6] as $j) {
                $depan = $lajuEfektif * $j;
                $belakang = $depan * 0.2;
                $a = ($depan + $belakang) / 2;
                $geser = ($depan - $belakang) / 2;
                $b = $a / $rasio;

                $nilai = pow(($u - $geser) / $a, 2) + pow($v / $b, 2);
                if ($nilai <= 1.0) {
                    $jamKena = $j;
                    break;
                }
            }

            if ($jamKena !== null) {
                $areaTerancam[] = [
                    'nama' => $permukiman->nama,
                    'jam' => $jamKena,
                ];
            }
        }

        $prediksi = PrediksiApi::create([
            'id_laporan' => $request->id_laporan,
            'latitude' => $lat,
            'longitude' => $long,
            'id_jenis_lahan' => $jenisLahan->id,
            'arah_angin' => $arahAngin,
            'kecepatan_angin' => $kecepatanAngin,
            'kelembapan' => $kelembapan,
            'curah_hujan' => $curahHujan,
            'laju_efektif' => round($lajuEfektif, 2),
            'poligon_1jam' => json_encode($poligonHasil[1]),
            'poligon_3jam' => json_encode($poligonHasil[3]),
            'poligon_6jam' => json_encode($poligonHasil[6]),
            'luas_1jam' => $luasHasil[1],
            'luas_3jam' => $luasHasil[3],
            'luas_6jam' => $luasHasil[6],
            'area_terancam' => json_encode($areaTerancam),
            'tampil_publik' => false,
            'id_admin' => Auth::id(),
        ]);

        return redirect()->route('admin.prediksi.index', ['id_prediksi' => $prediksi->id])->with('sukses', 'Prediksi perambatan kebakaran berhasil dihitung dan disimpan.');
    }

    public function togglePublik($id)
    {
        $prediksi = PrediksiApi::findOrFail($id);
        $prediksi->tampil_publik = !$prediksi->tampil_publik;
        $prediksi->save();

        $status = $prediksi->tampil_publik ? 'ditampilkan ke publik di halaman Peringatan dan Beranda' : 'disembunyikan dari publik';

        return redirect()->back()->with('sukses', 'Prediksi berhasil ' . $status . '.');
    }

    public function destroy($id)
    {
        $prediksi = PrediksiApi::findOrFail($id);
        $prediksi->delete();

        return redirect()->route('admin.prediksi.index')->with('sukses', 'Data riwayat prediksi berhasil dihapus.');
    }
}
