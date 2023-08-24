<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\BrandController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\InventoryController;


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
Route::get('/items/lowQuantityMail',[ItemController::class,'sendMail'])->middleware('auth');

Route::post('cart/purchases',[ItemController::class,'purchase'])->middleware('auth');


// Auth::routes();

// Route::get('/forgot-password', function () {
//     return view('auth.passwords.email');
// })->middleware('guest')->name('password.request');
// Route::post('/forgot-password', function (Request $request) {
//     $request->validate(['email' => 'required|email']);
 
//     $status = Password::sendResetLink(
//         $request->only('email')
//     );
 
//     return $status === Password::RESET_LINK_SENT
//                 ? back()->with(['status' => __($status)])
//                 : back()->withErrors(['email' => __($status)]);
// })->middleware('guest')->name('password.email');

// Route::get('/reset-password/{token}', function (string $token) {
//     return view('auth.passwords.reset', ['token' => $token]);
// })->middleware('guest')->name('password.reset');

// Route::post('/reset-password', function (Request $request) {
//     $request->validate([
//         'token' => 'required',
//         'email' => 'required|email',
//         'password' => 'required|confirmed|min:9|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
//     ]);
 
//     $status = Password::reset(
//         $request->only('email', 'password', 'password_confirm', 'token'),
//         function (User $user, string $password) {
//             $user->forceFill([
//                 'password' => Hash::make($password)
//             ])->setRememberToken(Str::random(60));
 
//             $user->save();
 
//             event(new PasswordReset($user));
//         }
//     );
 
//     return $status === Password::PASSWORD_RESET
//                 ? redirect()->route('login')->with('status', __($status))
//                 : back()->withErrors(['email' => [__($status)]]);
// })->middleware('guest')->name('password.update');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
