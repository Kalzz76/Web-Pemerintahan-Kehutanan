<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Administrator - Jaga Hutan Desa</title>
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
<body class="bg-stone-50 text-stone-800 font-sans antialiased min-h-screen flex items-center justify-center p-4">
    @php
        $pengaturanGlobal = \App\Models\PengaturanHutan::first();
    @endphp

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('beranda') }}" class="inline-flex items-center justify-center w-16 h-16 bg-white text-green-800 rounded-2xl shadow-sm border border-stone-100 mb-4 text-3xl hover:scale-105 transition">
                @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                    <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-10 h-10 object-contain rounded-lg">
                @else
                    <i class="fa-solid fa-tree"></i>
                @endif
            </a>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">{{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Desa' }}</h1>
            <p class="text-stone-500 text-xs mt-1">Panel Masuk Petugas Administrator</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-8 sm:p-10">
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-4 mb-6 text-sm">
                    <div class="flex items-center font-bold mb-1">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                        <span>Gagal Masuk</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.proses') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Nama Pengguna</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan nama pengguna" class="w-full pl-11 pr-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-green-600 focus:ring-2 focus:ring-green-100 outline-none transition">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-2">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-stone-400">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi" class="w-full pl-11 pr-4 py-3 rounded-xl border border-stone-200 text-sm focus:border-green-600 focus:ring-2 focus:ring-green-100 outline-none transition">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center cursor-pointer text-stone-600">
                        <input type="checkbox" name="ingat" class="rounded border-stone-300 text-green-700 focus:ring-green-500 mr-2">
                        <span>Ingat saya</span>
                    </label>

                    <a href="{{ route('lupa-password') }}" class="text-green-800 hover:text-green-600 font-semibold transition">
                        Lupa kata sandi?
                    </a>
                </div>

                <button type="submit" class="w-full py-3.5 px-6 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow-sm transition active:scale-95 text-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Masuk ke Panel Admin</span>
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('beranda') }}" class="inline-flex items-center text-xs font-semibold text-stone-500 hover:text-stone-800 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                <span>Kembali ke Beranda Publik</span>
            </a>
        </div>
    </div>
</body>
</html>
