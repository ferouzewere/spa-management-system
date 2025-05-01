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
use App\Models\Service;

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

    // Dashboard Tab Routes
    Route::get('/dashboard/appointments', function () {
        $appointments = Booking::where('customer_id', Auth::id())
            ->orderBy('appointment_time', 'desc')
            ->get();
        return view('dashboard.appointments', compact('appointments'));
    })->name('client.appointments');

    Route::get('/dashboard/payments', function () {
        $payments = Payment::where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('dashboard.payments', compact('payments'));
    })->name('client.payments');

    Route::get('/dashboard/reviews', function () {
        $reviews = Review::where('customer_id', Auth::id())
            ->with('service') // Eager load service relationship
            ->orderBy('created_at', 'desc')
            ->get();
        $services = Service::all(); // Get all services for the review form
        return view('dashboard.reviews', compact('reviews', 'services'));
    })->name('client.reviews');

    Route::post('/reviews', function (Request $request) {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        Review::create([
            'customer_id' => Auth::id(),
            'service_id' => $validated['service_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return back()->with('success', 'Review submitted successfully!');
    })->name('reviews.store');

    Route::get('/dashboard/notifications', function () {
        return view('dashboard.notifications');
    })->name('client.notifications');

    Route::get('/dashboard/settings', function () {
        return view('dashboard.settings');
    })->name('client.settings');

    // Booking Routes
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
    });

    // Payment Routes
    Route::get('/payments/mpesa', function () {
        return view('payments.mpesa');
    })->name('mpesa.payment');

    // Reviews Routes
    Route::get('/reviews', function () {
        return view('reviews.index');
    })->name('reviews.index');

    // ...rest of the existing routes...

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
Route::middleware(['auth'])->group(function () {
    Route::middleware('role:employee')->group(function () {
        Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
        Route::post('/employee/update-availability', [EmployeeController::class, 'updateAvailability'])->name('employee.updateAvailability');
        Route::get('/employee/appointments', [EmployeeController::class, 'manageAppointments'])->name('appointments.manage');
    });
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::resource('services', ServiceController::class)->except(['show']);
});
