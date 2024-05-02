<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [MovieController::class, 'index']);

Route::get('/movies/{id}', [MovieController::class, 'detail']);

Route::get('/admin/movies', [MovieController::class, 'admin']);

Route::get('/admin/movies/create', [MovieController::class, 'create']); 

Route::post('/admin/movies/store', [MovieController::class, 'store']);

Route::get('/admin/movies/{id}', [MovieController::class, 'adminDetail']);

Route::get('/admin/movies/{id}/edit', [MovieController::class, 'edit']);

Route::patch('/admin/movies/{id}/update',[MovieController::class, 'update']);

Route::delete('/admin/movies/{id}/destroy',[MovieController::class, 'destroy']);

Route::get('/admin/schedules', [MovieController::class, 'schedules']);

Route::get('/admin/movies/{id}/schedules/create', [MovieController::class, 'scheduleCreate']);

Route::post('/admin/movies/{id}/schedules/store', [MovieController::class, 'scheduleStore']);

Route::get('/admin/schedules/{id}', [MovieController::class,'scheduleDetail']);

Route::get('/admin/schedules/{id}/edit', [MovieController::class,'scheduleEdit']);

Route::patch('/admin/schedules/{id}/update',[MovieController::class, 'scheduleUpdate']);

Route::delete('/admin/schedules/{id}/destroy',[MovieController::class, 'scheduleDestroy']);

Route::get('/sheets', [MovieController::class, 'sheets']);

