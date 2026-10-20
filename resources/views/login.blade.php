<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Jawa Barat' }}</title>
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
<body class="bg-[#154735] text-white font-sans antialiased min-h-screen relative selection:bg-emerald-300 selection:text-emerald-950 overflow-x-hidden" style="background-color: #154735; background-image: url('{{ asset('images/background-login-v2.png') }}'); background-repeat: no-repeat; background-position: left center; background-size: contain;">
    @php
        $pengaturanGlobal = \App\Models\PengaturanHutan::first();
    @endphp

    <div class="fixed top-5 left-5 sm:top-8 sm:left-8 z-30">
        <a href="{{ route('beranda') }}" class="inline-flex items-center space-x-3 px-4 py-2 rounded-full bg-white/85 hover:bg-white/95 backdrop-blur-md border border-white/80 shadow-md transition hover:scale-[1.02] group">
            @if ($pengaturanGlobal && $pengaturanGlobal->logo)
                <img src="{{ asset('storage/' . $pengaturanGlobal->logo) }}" alt="Logo" class="w-8 h-8 object-contain rounded-full shadow-2xs">
            @else
                <div class="w-8 h-8 rounded-full bg-[#154735] text-white flex items-center justify-center text-xs shadow-2xs">
                    <i class="fa-solid fa-tree"></i>
                </div>
            @endif
            <div class="flex flex-col text-left">
                <span class="text-xs sm:text-sm font-extrabold text-stone-900 tracking-tight leading-tight group-hover:text-emerald-900 transition">
                    {{ $pengaturanGlobal->nama_aplikasi ?? 'Jaga Hutan Jawa Barat' }}
                </span>
                <span class="text-[10px] text-stone-500 font-medium leading-none mt-0.5">
                    Pemerintah Provinsi Jawa Barat
                </span>
            </div>
        </a>
    </div>

    <div class="min-h-screen w-full flex items-center justify-center lg:justify-end p-6 sm:p-10 lg:pr-20 xl:pr-28">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-[380px] pt-16 lg:pt-0">
            <div class="mb-7">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Login</h1>
            </div>

            @if ($errors->any())
                <div class="bg-rose-950/70 border border-rose-500/60 text-rose-200 rounded-2xl p-4 mb-6 text-sm backdrop-blur-md">
                    <div class="flex items-center font-bold mb-1 text-rose-100">
                        <i class="fa-solid fa-triangle-exclamation mr-2 text-rose-400"></i>
                        <span>Gagal Masuk</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-200">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.proses') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-white mb-2">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus placeholder="Enter your username" class="w-full px-5 py-3 rounded-full bg-black/35 hover:bg-black/40 focus:bg-black/50 border border-white/10 focus:border-white/30 text-white placeholder-white/45 text-sm outline-none transition backdrop-blur-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-white mb-2">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password" class="w-full px-5 py-3 rounded-full bg-black/35 hover:bg-black/40 focus:bg-black/50 border border-white/10 focus:border-white/30 text-white placeholder-white/45 text-sm outline-none transition backdrop-blur-sm">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center cursor-pointer text-white/80 select-none">
                        <input type="checkbox" name="ingat" class="rounded border-white/30 bg-black/30 text-emerald-500 focus:ring-emerald-400 mr-2">
                        <span>Remember me</span>
                    </label>

                    <a href="{{ route('lupa-password') }}" class="text-white/70 hover:text-white transition">
                        Forgot Password?
                    </a>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 px-6 bg-white hover:bg-stone-100 text-[#154735] font-bold rounded-full shadow-lg transition active:scale-95 text-sm flex items-center justify-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-right-to-bracket text-xs"></i>
                        <span>Login</span>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-5 border-t border-white/10 text-center lg:text-left">
                <a href="{{ route('beranda') }}" class="inline-flex items-center text-xs font-medium text-white/60 hover:text-white transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    <span>Kembali ke Beranda Publik</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
