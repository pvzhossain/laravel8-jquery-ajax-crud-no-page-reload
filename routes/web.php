<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/student', [StudentController::class, 'index'])->name('main_page');
Route::post('/student', [StudentController::class, 'store']);
Route::get('/fetch-student', [StudentController::class, 'show']);
Route::get('/edit-student/{id}', [StudentController::class, 'edit']);
Route::put('/update-student/{id}', [StudentController::class, 'update']);
Route::delete('/delete-student/{id}', [StudentController::class, 'delete']);


Route::get('/', function () {
    return redirect(route('main_page'));
});
