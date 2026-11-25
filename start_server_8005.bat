@echo off
setlocal
cd /d "%~dp0"

echo ============================================
echo   Server (port 8005)
echo ============================================

echo.
echo [1/2] Menjalankan Web Server (0.0.0.0:8005, bisa diakses dari IP manapun)...
start "Server 8005" cmd /k "php artisan serve --host=0.0.0.0 --port=8005"

echo.
echo [2/2] Menjalankan npm run dev (Vite)...
start "Server 8005 - Vite Dev" cmd /k "npm run dev"

timeout /t 3 /nobreak >nul
start http://localhost:8005

echo.
echo Server berjalan di port 8005 pada semua IP komputer ini (0.0.0.0).
echo Jangan tutup jendela "Server 8005" dan "Server 8005 - Vite Dev" selama aplikasi masih dipakai.
echo Jendela ini boleh ditutup kapan saja.
echo.
pause
