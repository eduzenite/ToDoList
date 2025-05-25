<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ToDoListController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/todo', [ToDoListController::class, 'index'])->name('todo.index');
    Route::post('/todo', [ToDoListController::class, 'store'])->name('todo.store');
    Route::get('/todo/{id}', [ToDoListController::class, 'show'])->name('todo.show');
    Route::put('/todo/{id}', [ToDoListController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [ToDoListController::class, 'destroy'])->name('todo.destroy');
});
