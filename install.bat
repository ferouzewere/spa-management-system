@echo off
echo Checking prerequisites...

where php >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo PHP is not installed. Please install PHP 8.2 or higher
    exit /b 1
)

where composer >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Composer is not installed. Please install Composer
    exit /b 1
)

where node >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo Node.js is not installed. Please install Node.js 16 or higher
    exit /b 1
)

where npm >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo npm is not installed. Please install npm
    exit /b 1
)

echo Installing PHP dependencies...
call composer install

echo Installing Node.js dependencies...
call npm install

echo Creating environment file...
copy .env.example .env

echo Generating application key...
php artisan key:generate

echo Creating SQLite database...
type nul > database\database.sqlite

echo Running database migrations and seeders...
php artisan migrate --seed

echo Installation complete! You can now start the development server.
echo If using Herd, visit http://spa-management-system.test
echo Otherwise, run 'php artisan serve' to start the development server
pause