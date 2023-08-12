<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/register', [AuthController::class,'register'])->name('register.api');
    Route::post('/login', [AuthController::class,'login'])->name('login.api');

// });

// Route::middleware('auth:api')->group(function () {
//     Route::post('/logout', [AuthController::class,'logout']);
//     Route::post('/passwordReset', [AuthController::class,'reset']);
// });

Route::group(['middleware' => 'auth:api'],function() {
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::get('/',[UserController::class, 'index']);
});

Route::post('/refresh', [AuthController::class,'refresh'])
->middleware('auth:api');



    
