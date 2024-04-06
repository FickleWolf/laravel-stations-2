<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice', [PracticeController::class, 'sample']);

Route::get('/practice2', [PracticeController::class, 'sample2']);

Route::get('/practice3', [PracticeController::class, 'sample3']);

Route::get('/getPractice', [PracticeController::class, 'getPractice']);
