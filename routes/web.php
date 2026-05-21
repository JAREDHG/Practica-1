<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\Admin\AuditController;

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

// PASO 5: Grupo de rutas exclusivas para el panel Administrativo
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal del administrador
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD completo de posts para el administrador
    Route::resource('/posts', PostAdminController::class);
    
    // Rutas de solo lectura para la auditoría (index y show)
    Route::resource('/audits', AuditController::class)->only(['index', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';