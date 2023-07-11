<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[ManageUsersController::class, 'index']);
Route::get('/users/create',[ManageUsersController::class, 'create']);
Route::post('/',[ManageUsersController::class, 'store']);
Route::get('/users/{user}/edit',[ManageUsersController::class, 'edit']);
Route::put('/users/{user}',[ManageUsersController::class, 'update']);
Route::delete('/users/{user}',[ManageUsersController::class, 'destroy']);









