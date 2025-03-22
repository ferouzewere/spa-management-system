<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\BookingController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'create']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Client Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    Route::match(['get', 'post'], '/book', [BookingController::class, 'create'])->name('book.create');

    Route::get('/payments/mpesa', function () {
        return view('payments.mpesa');
    })->name('mpesa.payment');

    Route::get('/reviews', function () {
        return view('reviews.index');
    })->name('reviews.index');
});

// Employee Routes
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::post('/employee/update-availability', [EmployeeController::class, 'updateAvailability'])->name('employee.updateAvailability');
    Route::get('/employee/appointments', [EmployeeController::class, 'manageAppointments'])->name('appointments.manage');
    Route::get('/dashboard/employee', [EmployeeController::class, 'dashboard'])->name('dashboard.employee');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/bookings/{id}', [AdminController::class, 'updateBookingStatus'])->name('admin.updateBookingStatus');
    Route::get('/admin/bookings', function () {
        return view('bookings.index');
    })->name('admin.bookings');
    Route::get('/admin/employees', function () {
        return view('employees.index');
    })->name('admin.employees');
    Route::get('/admin/services', function () {
        return view('services.index');
    })->name('admin.services');
    Route::get('/admin/reports', function () {
        return view('reports.transactions');
    })->name('admin.reports');
});

Route::get('/404', function () {
    return view('errors.404');
})->name('error.404');

Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
Route::post('/bookings', [BookingController::class, 'store'])->name('book.create');
