<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservedController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/setup-admin', function () {
    if (User::where('role', 'admin')->exists()) {
        return 'Admin already exists.';
    }

    User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    return 'Admin created: admin@example.com / password';
});


Route::get('/reserved', [ReservedController::class, 'index'])->name('reserved.index');
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');



Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
