<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BrandController;
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
Route::get('/vendors/create',[VendorController::class, 'create'])->middleware('auth');
Route::post('/vendors',[VendorController::class, 'store'])->middleware('auth');
Route::get('/vendors/{vendor}/edit',[VendorController::class, 'edit'])->middleware('auth');
Route::put('/vendors/{vendor}',[VendorController::class, 'update'])->middleware('auth');
Route::delete('/vendors/{vendor}',[VendorController::class, 'destroy'])->middleware('auth');


// Brand routes
Route::get('/brands',[BrandController::class, 'index']);
Route::get('/brands/create',[BrandController::class, 'create'])->middleware('auth');
Route::post('/brands',[BrandController::class, 'store'])->middleware('auth');
Route::get('/brands/{brand}/edit',[BrandController::class, 'edit'])->middleware('auth');
Route::put('/brands/{brand}',[BrandController::class, 'update'])->middleware('auth');
Route::delete('/brands/{brand}',[BrandController::class, 'destroy'])->middleware('auth');


// Item routes
Route::get('/items',[ItemController::class, 'index']);
Route::get('/items/create',[ItemController::class, 'create'])->middleware('auth');
Route::post('/items',[ItemController::class, 'store'])->middleware('auth');
Route::get('/items/{item}/edit',[ItemController::class, 'edit'])->middleware('auth');
Route::put('/items/{item}',[ItemController::class, 'update'])->middleware('auth');
Route::delete('/items/{item}',[ItemController::class, 'destroy'])->middleware('auth');

//image routes
// Route::controller(ImageController::class)->group(function(){
//     Route::get('/image-upload', 'index')->name('image.form');
//     Route::post('/upload-image', 'storeImage')->name('image.store');
// });


Auth::routes();
// Route::group(['middleware' => 'admin'], function(){

//     //all the routes protected by the admin middleware 
//     Route::get('/users/create',[ManageUsersController::class, 'create'])->middleware('auth');


// });


