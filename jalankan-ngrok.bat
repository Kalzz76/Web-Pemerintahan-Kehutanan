@echo off
setlocal
cd /d %~dp0

title Jaga Hutan Desa - Ngrok Tunnel
color 0B
echo ========================================================
echo   JAGA HUTAN DESA - NGROK TUNNEL (HTTPS)
echo ========================================================
echo.

echo [1/3] Memeriksa MySQL di XAMPP...
netstat -ano | findstr ":3306" | findstr "LISTENING" >nul
if errorlevel 1 (
    echo [PERINGATAN] MySQL di XAMPP belum menyala!
    echo Silakan buka XAMPP Control Panel lalu klik START pada MySQL.
    echo.
) else (
    echo [OK] MySQL di XAMPP sudah aktif.
)
echo.

echo [2/3] Menjalankan server Laravel di http://127.0.0.1:8000...
netstat -ano | findstr ":8000" | findstr "LISTENING" >nul
if errorlevel 1 (
    echo Membuka jendela server Laravel...
    start "Laravel Server" cmd /k "cd /d %~dp0 && title Laravel Server - JANGAN DITUTUP && php artisan serve --host=127.0.0.1 --port=8000"
    echo Menunggu server Laravel siap...
    ping 127.0.0.1 -n 4 >nul
) else (
    echo [OK] Server Laravel sudah aktif di port 8000.
)

netstat -ano | findstr ":8000" | findstr "LISTENING" >nul
if errorlevel 1 (
    echo.
    echo ========================================================
    echo PERHATIAN: Server Laravel belum terdeteksi di port 8000.
    echo Cek jendela 'Laravel Server' yang terbuka untuk melihat error.
    echo Pastikan MySQL di XAMPP sudah di-START.
    echo ========================================================
    echo.
)

echo.
echo [3/3] Menghubungkan ke Ngrok Tunnel...
echo Tautan HTTPS (*.ngrok-free.app) akan muncul di dashboard Ngrok di bawah ini:
echo ========================================================
echo CATATAN PENTING:
echo - Jendela 'Laravel Server' JANGAN DITUTUP selama website aktif.
echo - Jika selesai, matikan lewat file: matikan-semua.bat
echo ========================================================
echo.
"C:\Users\master\AppData\Local\Microsoft\WinGet\Links\ngrok.exe" http 8000
pause
