#!/bin/bash

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP 8.2 or higher"
    exit 1
fi

# Check if Composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer"
    exit 1
fi

# Check if Node.js is installed
if ! command -v node &> /dev/null; then
    echo "Node.js is not installed. Please install Node.js 16 or higher"
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "npm is not installed. Please install npm"
    exit 1
fi

echo "Installing PHP dependencies..."
composer install

echo "Installing Node.js dependencies..."
npm install

echo "Creating environment file..."
cp .env.example .env

echo "Generating application key..."
php artisan key:generate

echo "Creating SQLite database..."
touch database/database.sqlite

echo "Running database migrations and seeders..."
php artisan migrate --seed

echo "Installation complete! You can now start the development server."
echo "If using Herd, visit http://spa-management-system.test"
echo "Otherwise, run 'php artisan serve' to start the development server"