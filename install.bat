@echo off
echo ========================================
echo AgriPulse - Dairy Farm Management System
echo Installation Script for Windows
echo ========================================
echo.

echo [1/7] Installing Composer dependencies...
call composer install
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed!
    pause
    exit /b 1
)
echo ✓ Composer dependencies installed
echo.

echo [2/7] Installing NPM dependencies...
call npm install
if %errorlevel% neq 0 (
    echo ERROR: NPM install failed!
    pause
    exit /b 1
)
echo ✓ NPM dependencies installed
echo.

echo [3/7] Setting up environment file...
if not exist .env (
    copy .env.example .env
    echo ✓ Environment file created
) else (
    echo ✓ Environment file already exists
)
echo.

echo [4/7] Generating application key...
call php artisan key:generate
echo ✓ Application key generated
echo.

echo [5/7] Setting up SQLite database...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo ✓ SQLite database file created
) else (
    echo ✓ SQLite database file already exists
)
echo.

echo [6/7] Running migrations and seeders...
call php artisan migrate --seed
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)
echo ✓ Database migrated and seeded
echo.

echo [7/7] Building frontend assets...
call npm run build
if %errorlevel% neq 0 (
    echo ERROR: Asset build failed!
    pause
    exit /b 1
)
echo ✓ Frontend assets built
echo.

echo ========================================
echo Installation Complete! 🎉
echo ========================================
echo.
echo Your AgriPulse system is ready to use!
echo.
echo To start the server, run:
echo   php artisan serve
echo.
echo Then open your browser and go to:
echo   http://localhost:8000
echo.
echo Login credentials:
echo   Email: admin@agripulse.com
echo   Password: password
echo.
echo ========================================
pause
