@echo off
setlocal
cd /d "%~dp0"

title Matikan Semua Server dan Tunnel
color 0C
echo ========================================================
echo   MEMATIKAN SEMUA SERVER DAN TUNNEL
echo ========================================================
echo.
echo [1/3] Menghentikan Cloudflare Tunnel...
taskkill /f /im cloudflared.exe >nul 2>&1

echo [2/3] Menghentikan Ngrok Tunnel...
taskkill /f /im ngrok.exe >nul 2>&1

echo [3/3] Menghentikan Server Laravel (Port 8000)...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr ":8000" ^| findstr "LISTENING"') do taskkill /f /pid %%a >nul 2>&1

taskkill /f /fi "WINDOWTITLE eq Laravel Server*" /im cmd.exe >nul 2>&1
taskkill /f /fi "WINDOWTITLE eq Ngrok Tunnel*" /im cmd.exe >nul 2>&1

echo.
echo ========================================================
echo [OK] SEMUA SERVER DAN TUNNEL BERHASIL DIMATIKAN!
echo ========================================================
ping 127.0.0.1 -n 3 >nul
