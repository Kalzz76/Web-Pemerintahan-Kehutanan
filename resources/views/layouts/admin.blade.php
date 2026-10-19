<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Jaga Hutan Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-stone-50 text-stone-800 font-sans antialiased min-h-screen">
    @php
        $jumlahLaporanBaru = \App\Models\Laporan::where('status', 'Baru')->count();
        $pengaturanGlobal = \App\Models\PengaturanHutan::first();
    @endphp

    <div class="flex flex-col md:flex-row min-h-screen">
        <aside class="w-full md:w-64 bg-stone-900 text-stone-300 flex flex-col justify-between shrink-0 shadow-lg">
            <div>
                <div class="p-6 border-b border-stone-800 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-white text-green-900 flex items-center justify-center font-black text-xl shrink-0 shadow">
                        @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                            <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-8 h-8 object-contain rounded-lg">
                        @else
                            <i class="fa-solid fa-tree"></i>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs uppercase font-extrabold tracking-wider text-green-400">Administrator</div>
                        <div class="text-sm font-bold text-white tracking-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</div>
                    </div>
                </div>

                <div class="px-4 py-2 border-b border-stone-800 text-xs text-stone-400 flex items-center justify-between">
                    <span>Masuk sebagai:</span>
                    <span class="font-semibold text-white">{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>

                <nav class="p-4 space-y-1 text-sm overflow-y-auto max-h-[calc(100vh-210px)]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white shadow-sm' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-gauge w-5 mr-3 text-center"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ Route::has('admin.kawasan.index') ? route('admin.kawasan.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/kawasan*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-mountain-sun w-5 mr-3 text-center"></i>
                        <span>A. Kawasan Hutan</span>
                    </a>

                    <a href="{{ Route::has('admin.titik-penting.index') ? route('admin.titik-penting.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/titik-penting*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-location-dot w-5 mr-3 text-center"></i>
                        <span>B. Titik Penting</span>
                    </a>

                    <a href="{{ Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#' }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/laporan*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <div class="flex items-center">
                            <i class="fa-solid fa-triangle-exclamation w-5 mr-3 text-center"></i>
                            <span>C. Kelola Laporan</span>
                        </div>
                        @if ($jumlahLaporanBaru > 0)
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-rose-600 text-white">
                                {{ $jumlahLaporanBaru }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ Route::has('admin.prediksi.index') ? route('admin.prediksi.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/prediksi*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-fire-flame-curved w-5 mr-3 text-center"></i>
                        <span>D. Prediksi Kebakaran</span>
                    </a>

                    <a href="{{ Route::has('admin.primata.index') ? route('admin.primata.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/primata*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-paw w-5 mr-3 text-center"></i>
                        <span>E. Primata</span>
                    </a>

                    <a href="{{ Route::has('admin.tumbuhan.index') ? route('admin.tumbuhan.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/tumbuhan*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-seedling w-5 mr-3 text-center"></i>
                        <span>F. Tumbuhan</span>
                    </a>

                    <a href="{{ Route::has('admin.pengumuman.index') ? route('admin.pengumuman.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/pengumuman*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-bullhorn w-5 mr-3 text-center"></i>
                        <span>G. Pengumuman</span>
                    </a>

                    <a href="{{ Route::has('admin.jadwal-patroli.index') ? route('admin.jadwal-patroli.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/jadwal-patroli*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-regular fa-calendar-check w-5 mr-3 text-center"></i>
                        <span>H. Jadwal Patroli</span>
                    </a>

                    <a href="{{ Route::has('admin.kontak-darurat.index') ? route('admin.kontak-darurat.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/kontak-darurat*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-phone-volume w-5 mr-3 text-center"></i>
                        <span>I. Kontak Darurat</span>
                    </a>

                    <a href="{{ Route::has('admin.jenis-lahan.index') ? route('admin.jenis-lahan.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/jenis-lahan*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-layer-group w-5 mr-3 text-center"></i>
                        <span>J. Jenis Lahan</span>
                    </a>

                    <a href="{{ Route::has('admin.akun.index') ? route('admin.akun.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/akun*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-users-gear w-5 mr-3 text-center"></i>
                        <span>K. Akun Admin</span>
                    </a>

                    <a href="{{ Route::has('admin.pengaturan.index') ? route('admin.pengaturan.index') : '#' }}" class="flex items-center px-4 py-2.5 rounded-xl font-medium transition {{ request()->is('admin/pengaturan*') ? 'bg-green-700 text-white' : 'hover:bg-stone-800 hover:text-white' }}">
                        <i class="fa-solid fa-sliders w-5 mr-3 text-center"></i>
                        <span>L. Pengaturan</span>
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-stone-800 space-y-2">
                <a href="{{ route('beranda') }}" target="_blank" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl text-stone-300 hover:bg-stone-800 hover:text-white text-xs font-semibold transition">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-2"></i>
                    <span>Buka Halaman Publik</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari sistem?')">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold text-xs transition">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6 md:p-10 max-w-7xl mx-auto w-full">
            @if ($errors->any())
                <div class="bg-rose-50 text-rose-700 rounded-xl p-5 mb-8 border border-rose-200 shadow-sm">
                    <div class="flex items-center mb-2 font-bold text-sm">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        <span>Terdapat kesalahan pada input:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @include('partials.modal-pesan')
    @yield('scripts')
</body>
</html>
