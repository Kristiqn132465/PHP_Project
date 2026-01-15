<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservedController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/reservation', [ReservationController::class, 'create'])
    ->name('reservation.create');

Route::post('/reservation', [ReservationController::class, 'store'])
    ->name('reservation.store');

Route::get('/reserved', [ReservedController::class, 'index'])
    ->name('reserved.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/reserved/{reservation}/edit', [ReservedController::class, 'edit'])
        ->name('reserved.edit');

    Route::put('/reserved/{reservation}', [ReservedController::class, 'update'])
        ->name('reserved.update');

    Route::delete('/reserved/{reservation}', [ReservedController::class, 'destroy'])
        ->name('reserved.destroy');
});

require __DIR__.'/auth.php';

//Route::get('/setup-admin', function () {
//    if (User::where('role', 'admin')->exists()) {
//        return 'Admin already exists.';
//    }
//
//    User::create([
//        'name' => 'Admin',
//        'email' => 'admin@example.com',
//        'password' => Hash::make('password'),
//        'role' => 'admin',
//    ]);
//
//    return 'Admin created: admin@example.com / password';
//});