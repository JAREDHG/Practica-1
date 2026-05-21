<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController; // Importamos el controlador
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Se agrupam las rutas que requieren que el usuario esté autenticado y verificado
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard protegido para admin y editor
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    // Rutas de Posts protegidas por rol específico
    Route::post('/posts', [PostController::class, 'store'])->middleware('role:editor');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('role:admin');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';