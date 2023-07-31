<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\InventoryController;
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
Route::get('/brands/{brand}',[BrandController::class, 'show'])->middleware('auth');


// Item routes
Route::get('/items',[ItemController::class, 'index']);
Route::get('/items/create',[ItemController::class, 'create'])->middleware('auth');
Route::post('/items',[ItemController::class, 'store'])->middleware('auth');
Route::get('/items/{item}/edit',[ItemController::class, 'edit'])->middleware('auth');
Route::put('/items/{item}',[ItemController::class, 'update'])->middleware('auth');
Route::delete('/items/{item}',[ItemController::class, 'destroy'])->middleware('auth');
Route::get('/items/{item}',[ItemController::class, 'show'])->middleware('auth');


// Inventory routes
Route::get('/inventories',[InventoryController::class, 'index']);
Route::get('/inventories/create',[InventoryController::class, 'create'])->middleware('auth');
Route::post('/inventories',[InventoryController::class, 'store'])->middleware('auth');
Route::get('/inventories/{inventory}/edit',[InventoryController::class, 'edit'])->middleware('auth');
Route::put('/inventories/{inventory}',[InventoryController::class, 'update'])->middleware('auth');
Route::delete('/inventories/{inventory}',[InventoryController::class, 'destroy'])->middleware('auth');
Route::get('/inventories/{inventory}',[InventoryController::class, 'show'])->middleware('auth');


Route::get('/Items',[ItemController::class,'items'])->middleware('auth');
Route::get('cart',[ItemController::class, 'cart'])->middleware('auth');
Route::get('add-to-cart/{item}',[ItemController::class, 'add_to_cart'])->middleware('auth');
Route::put('update-cart/{item}', [ItemController::class, 'updateCart'])->middleware('auth');
Route::delete('remove-from-cart/{item}', [ItemController::class, 'deleteCartItem'])->middleware('auth');
Route::get('/cart/purchase',[ItemController::class,'purchase'])->middleware('auth');
Route::get('/items/lowQuantityMail',[ItemController::class,'sendMail'])->middleware('auth');



Auth::routes();
// Route::group(['middleware' => 'admin'], function(){
//     //all the routes protected by the admin middleware 
//     Route::get('/users/create',[ManageUsersController::class, 'create'])->middleware('auth');
// });


