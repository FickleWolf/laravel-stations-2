<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice', [PracticeController::class, 'sample']);

Route::get('/practice2', [PracticeController::class, 'sample2']);

Route::get('/practice3', [PracticeController::class, 'sample3']);

Route::get('/getPractice', [PracticeController::class, 'getPractice']);

Route::get('/movies', [MovieController::class, 'index']);

Route::get('/admin/movies', [MovieController::class, 'admin']);

Route::get('/admin/movies/create', [MovieController::class, 'create']);

Route::post('/admin/movies/store', [MovieController::class, 'store']);

Route::get('/admin/movies/{id}/edit', [MovieController::class, 'edit']);

Route::patch('/admin/movies/{id}/update',[MovieController::class, 'update']);

Route::delete('/admin/movies/{id}/destroy',[MovieController::class, 'destroy']);
