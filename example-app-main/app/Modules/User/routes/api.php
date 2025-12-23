<?php

use Illuminate\Support\Facades\Route;
use App\Modules\User\App\Http\Middleware\Admin;
use App\Modules\User\App\Http\Controllers\RoleController;
use App\Modules\User\App\Http\Controllers\UserController;
use App\Modules\User\App\Http\Controllers\PermissionController;


Route::group(['middleware' => ['auth:api', 'Admin']],function() {  
 
    Route::apiResource('users', UserController::class);
    Route::post('/search', [UserController::class, 'search']);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
});

?>

