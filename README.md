# Spa Management System

A comprehensive spa management system built with Laravel and modern frontend technologies. This system helps manage spa services, appointments, employees, and customer bookings.

## Features

- User Authentication and Authorization
- Employee Management with Work Schedules
- Service Management
- Booking System
- Payment Status Management
- Customer Reviews
- Role-based Access Control

## Prerequisites

- [Herd](https://herd.laravel.com/) for local PHP development
- PHP 8.1 or higher
- Composer
- Node.js (16.x or higher)
- npm or yarn
- SQLite (included with Herd)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd spa-management-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

7. Create the SQLite database:
```bash
touch database/database.sqlite
```

8. Run migrations and seed the database:
```bash
php artisan migrate --seed
```

9. Start the development server (using Herd):
```bash
php artisan serve
```

10. In a separate terminal, start the Vite development server:
```bash
npm run dev
```

## Usage

Access the application at `http://spa-management-system.test` (if using Herd) or the URL provided by the `php artisan serve` command.

## Development

- Frontend assets are compiled using Vite
- The application uses Laravel's built-in authentication
- Database migrations are located in `database/migrations`
- Models are located in `app/Models`
- Controllers are in `app/Http/Controllers`

## Testing

Run the test suite using:
```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

[MIT License](LICENSE.md)
