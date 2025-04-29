<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\BookingController;
use App\Models\Booking;
use App\Models\Appointment;
use App\Models\Payment;
use App\Models\Review;
use App\Models\User;

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

Route::get('/404', function () {
    return view('errors.404');
})->name('error.404');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Client Dashboard & Features
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');

    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Payment Routes
    Route::get('/payments/mpesa', function () {
        return view('payments.mpesa');
    })->name('mpesa.payment');

    // Reviews Routes
    Route::get('/reviews', function () {
        return view('reviews.index');
    })->name('reviews.index');

    // Dashboard Tab Routes
    Route::get('/dashboard/appointments', function () {
        $appointments = Appointment::where('user_id', Auth::id())->get();
        return view('dashboard.appointments', compact('appointments'));
    });

    Route::get('/dashboard/payments', function () {
        $payments = Payment::where('user_id', Auth::id())->get();
        return view('dashboard.payments', compact('payments'));
    });

    Route::get('/dashboard/reviews', function () {
        $reviews = Review::where('user_id', Auth::id())->get();
        return view('dashboard.reviews', compact('reviews'));
    });

    Route::get('/dashboard/notifications', function () {
        return view('dashboard.notifications');
    });

    Route::get('/dashboard/settings', function () {
        return view('dashboard.settings');
    });

    // Profile Settings Routes
    Route::put('/profile/update', function (Request $request) {
        /** @var \App\Models\User */
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'preferences' => 'array'
        ]);

        if (isset($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json(['success' => false, 'message' => 'Current password is incorrect'], 422);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }
        if (isset($validated['preferences'])) {
            $user->preferences = $validated['preferences'];
        }

        try {
            $user->save();
            return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update profile'], 500);
        }
    })->name('profile.update');
});

// Employee Routes
Route::middleware(['auth', 'role:employee'])->group(function () {
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::post('/employee/update-availability', [EmployeeController::class, 'updateAvailability'])->name('employee.updateAvailability');
    Route::get('/employee/appointments', [EmployeeController::class, 'manageAppointments'])->name('appointments.manage');
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
