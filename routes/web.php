<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AppointmentController; // <-- ADICIONE ESTA LINHA
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redireciona o dashboard direto para os agendamentos (igual fizemos no outro projeto!)
Route::get('/dashboard', function () {
    return redirect()->route('appointments.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // <-- NOSSA ROTA DE AGENDAMENTOS -->
    Route::resource('appointments', AppointmentController::class);
});

require __DIR__.'/auth.php';