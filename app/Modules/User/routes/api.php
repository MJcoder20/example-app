<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\App\Http\Middleware\Admin;
use App\Modules\User\App\Http\Controllers\UserController;


Route::group(['middleware' => ['auth:api', 'Admin']],function() {  
 
    Route::resource('users', UserController::class);
    Route::post('/search', [UserController::class, 'search']);
    
});

?>

