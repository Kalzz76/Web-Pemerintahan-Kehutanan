<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petunjuk Lupa Kata Sandi - Jaga Hutan Desa</title>
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

    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-100 text-amber-700 rounded-2xl shadow-sm mb-4 text-3xl">
                <i class="fa-solid fa-key"></i>
            </div>
            <h1 class="text-2xl font-black text-stone-900 tracking-tight">Petunjuk Pemulihan Kata Sandi</h1>
            <p class="text-stone-500 text-xs mt-1">Sistem Pengelolaan Jaga Hutan Desa</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 p-8 sm:p-10 space-y-6">
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-sm leading-relaxed flex items-start space-x-3">
                <i class="fa-solid fa-circle-info text-amber-600 mt-0.5 text-base shrink-0"></i>
                <p>
                    Sistem ini beroperasi secara mandiri di tingkat desa dan <strong>tidak menggunakan layanan pengiriman surel (email)</strong> untuk mengatur ulang kata sandi.
                </p>
            </div>

            <div class="space-y-4 text-sm text-stone-700">
                <h2 class="font-bold text-stone-900 text-base">Langkah-langkah yang harus dilakukan:</h2>

                <div class="flex items-start space-x-3">
                    <span class="w-6 h-6 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">1</span>
                    <p>
                        <strong>Hubungi Rekan Administrator Lain:</strong> Silakan sampaikan kepada sesama admin atau ketua satgas desa yang memiliki akses aktif ke sistem.
                    </p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-6 h-6 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">2</span>
                    <p>
                        <strong>Reset Lewat Menu Akun Admin:</strong> Rekan admin dapat membuka menu <em>Akun Admin</em> pada dashboard administrator, lalu menekan tombol <em>Edit</em> pada baris akun Anda untuk menentukan kata sandi baru.
                    </p>
                </div>

                <div class="flex items-start space-x-3">
                    <span class="w-6 h-6 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">3</span>
                    <p>
                        <strong>Bagi Admin Tunggal:</strong> Apabila hanya ada satu akun dan tidak ada admin lain, silakan hubungi penanggung jawab teknis server desa untuk melakukan pembaruan kata sandi langsung dari konsol basis data.
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-stone-100">
                <a href="{{ route('login') }}" class="w-full py-3.5 px-6 bg-green-700 hover:bg-green-600 text-white font-bold rounded-xl shadow-sm transition active:scale-95 text-sm flex items-center justify-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Halaman Masuk</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
