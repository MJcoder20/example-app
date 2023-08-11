<?php

use App\Enums\TokenAbility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
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
Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    // Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    // Route::post('/register', 'Auth\ApiAuthController@register')->name('register.api');
    Route::post('/register', [AuthController::class,'register'])->name('register.api');
    Route::post('/login', [AuthController::class,'login'])->name('login.api');

    // ...

});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    // Route::get('/', [UserController::class, 'index']);
    // Route::get('/items', [ItemController::class, 'index']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/passwordReset', [AuthController::class,'reset']);
});


Route::post('/refresh', [AuthController::class,'refresh'])
->middleware(['auth:api']);

    
