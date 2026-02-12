@echo off
cd /d "%~dp0"

echo Ensuring application key is set...
php artisan key:generate --force 2>nul

echo.
echo Starting Laravel development server...
echo Open in your browser: http://127.0.0.1:8000
echo Press Ctrl+C to stop the server.
echo.

php artisan serve

pause
