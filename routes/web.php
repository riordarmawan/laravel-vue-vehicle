<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Exports\VehiclesExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/users', function () {
    return Inertia::render('Users');
})->name('users.index');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

Route::get('/vehicles/export', function () {
    return Excel::download(new VehiclesExport, 'vehicles.xlsx');
})->name('vehicles.export');

Route::get('/list_vehicle', [VehicleController::class, 'listVehicle'])->name('listVehicle');

require __DIR__ . '/auth.php';
