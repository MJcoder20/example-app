<?php

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\API\AuthController;


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


// Route::post('/register', [AuthController::class,'register']);
// Route::post('/login', [AuthController::class,'login']);
Route::group(['middleware' => ['cors', 'json.response']], function () {
    //Google
    Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
    Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);
    //Facebook
    Route::get('/login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
    Route::get('/login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    //Github
    Route::get('/login/github', [AuthController::class, 'redirectToGithub'])->name('login.github');
    Route::get('/login/github/callback', [AuthController::class, 'handleGithubCallback']);
   
    Route::post('/login', [AuthController::class,'login']);
    Route::post('/register', [AuthController::class,'register']);
    
});


Route::group(['middleware' => 'auth:api'],function() {  
    Route::get('auth/{provider}', 'AuthController@redirectToProvider')->name('social.redirect');
    Route::get('auth/{provider}/callback', 'AuthController@handleProviderCallback')->name('social.callback');
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::post('/reset', [AuthController::class, 'reset']);
    Route::post('/refresh', [AuthController::class,'refresh']);
});



    
