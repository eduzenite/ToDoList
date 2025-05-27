<?php

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Api\ToDoListController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::group([
        "prefix" => "profile",
    ], function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::get('/todo', [ToDoListController::class, 'index'])->name('todo.index');
    Route::post('/todo', [ToDoListController::class, 'store'])->name('todo.store');
    Route::get('/todo/{id}', [ToDoListController::class, 'show'])->name('todo.show');
    Route::put('/todo/{id}', [ToDoListController::class, 'update'])->name('todo.update');
    Route::patch('/todo-status/{id}', [ToDoListController::class, 'updateStatus'])->name('todo.updateStatus');
    Route::delete('/todo/{id}', [ToDoListController::class, 'destroy'])->name('todo.destroy');
});

require __DIR__.'/auth.php';
