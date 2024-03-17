<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TodoController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/todos', [TodoController::class, 'todos'])->name('todos');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::post('/todos/update', [TodoController::class, 'update'])->name('todos.update');
    Route::post('/todos/status', [TodoController::class, 'change_status'])->name('todos.status');
    Route::delete('/todos/{id}', [TodoController::class, 'delete']);
});
