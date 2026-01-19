<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserController;


Route::get('/',[UserController::class, 'index'])->name('index')->middleware(['Admin']);
Route::middleware(['web','auth'])->group(function () {
    Route::get('/users/create', [UserController::class, 'create']);
    Route::get('/users/{user}/edit',[UserController::class, 'edit']);
});
Route::post('/',[UserController::class, 'store'])->middleware('auth');
Route::put('/users/{user}',[UserController::class, 'update'])->middleware('auth');
Route::delete('/users/{user}',[UserController::class, 'destroy'])->middleware('auth');



?>