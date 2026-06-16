<?php

use Illuminate\Support\Facades\Route;

// Si un usuario ya está logueado e intenta entrar a la raíz, el middleware 'guest' lo manda al dashboard.
// Si no está logueado, lo redirige limpiamente al formulario de Login.
Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Si entran a la raíz estando logueados, van al dashboard
    Route::redirect('/', '/dashboard');

    // Panel principal con nuestro listado premium
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    // Perfil de usuario
    Route::view('profile', 'profile')->name('profile');

    Route::get('tickets/{ticket}', \App\Livewire\Ticket\ShowTicket::class)->name('tickets.show');

});

require __DIR__.'/auth.php';