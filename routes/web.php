<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ManageUsersController;

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

//User routes
Route::get('/',[ManageUsersController::class, 'index'])->name('index')->middleware('auth');
Route::get('/users/create',[ManageUsersController::class, 'create'])->middleware('auth');
Route::post('/',[ManageUsersController::class, 'store'])->middleware('auth');
Route::get('/users/{user}/edit',[ManageUsersController::class, 'edit'])->middleware('auth');
Route::put('/users/{user}',[ManageUsersController::class, 'update'])->middleware('auth');
Route::delete('/users/{user}',[ManageUsersController::class, 'destroy'])->middleware('auth');
// Route::post('/users/search',[ManageUsersController::class, 'search'])->middleware('auth');


// Vendor routes
Route::get('/vendors',[VendorController::class, 'index']);
Route::get('/vendors/create',[VendorController::class, 'create']);
Route::post('/vendors',[VendorController::class, 'store']);
Route::get('/vendors/{vendor}/edit',[VendorController::class, 'edit']);
Route::put('/vendors/{vendor}',[VendorController::class, 'update']);
Route::delete('/vendors/{vendor}',[VendorController::class, 'destroy']);
// Route::post('/vendors/search',[VendorController::class, 'search']);


Auth::routes();
// Route::group(['middleware' => 'admin'], function(){

//     //all the routes protected by the admin middleware 
//     Route::get('/users/create',[ManageUsersController::class, 'create'])->middleware('auth');


// });


