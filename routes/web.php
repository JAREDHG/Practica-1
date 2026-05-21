<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Se agrupan las rutas que requieren que el usuario esté autenticado y verificado
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard protegido para admin y editor
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    // Rutas para ver el formulario y mostrar un post específico
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // Rutas de Posts protegidas por rol específico
    Route::post('/posts', [PostController::class, 'store'])->middleware('role:editor,admin')->name('posts.store');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('role:admin');
    
    // Eliminación de archivos adjuntos
    Route::delete('/attachments/{attachment}', [PostController::class, 'destroyAttachment'])->name('attachments.destroy');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';