<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;


Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::post('/todo/store', [TodoController::class, 'store'])->name('todo.store');
Route::post('/todo/update-status/{id}', [TodoController::class, 'updateStatus'])->name('todo.updateStatus');
Route::get('/todo/edit/{id}', [TodoController::class, 'edit'])->name('todo.edit');
Route::post('/todo/update/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/todo/destroy/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');

