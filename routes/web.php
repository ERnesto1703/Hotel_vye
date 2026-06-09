<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/sobre-nosotros', [BookingController::class, 'sobreNosotros'])->name('sobre-nosotros');
Route::get('/transporte', [BookingController::class, 'transporte'])->name('transporte');
Route::get('/habitaciones', [BookingController::class, 'habitaciones'])->name('habitaciones');
Route::get('/reservas', [BookingController::class, 'createReserva'])->name('reservas.create');
Route::post('/reservas', [BookingController::class, 'storeReserva'])->name('reservas.store');
Route::get('/admin', [BookingController::class, 'admin'])->name('admin');

use Illuminate\Support\Facades\Artisan;

Route::get('/instalar-bd-secreta', function () {
    try {
        Artisan::call('migrate:fresh', ['--seed' => true]);
        return '¡Base de datos migrada y sembrada con éxito!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
