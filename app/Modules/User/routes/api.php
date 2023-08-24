<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\App\Http\Controllers\UserController;


Route::group(['middleware' => 'auth:api'],function() {  
 
    Route::resource('users', UserController::class);

});

?>

