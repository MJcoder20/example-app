<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\App\Http\Controllers\UserController;


// Route::post('/register', [AuthController::class,'register']);
// Route::post('/login', [AuthController::class,'login']);

Route::group(['middleware' => 'auth:api'],function() {  
    // Route::post('/logout',[AuthController::class, 'logout']);
    // Route::post('/reset', [AuthController::class, 'reset']);
    // Route::post('/refresh', [AuthController::class,'refresh']);
    Route::resource('users', UserController::class);

});

?>

