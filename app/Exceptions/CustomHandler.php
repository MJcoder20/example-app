<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Exceptions\Handler as ExceptionHandler;

class CustomHandler extends ExceptionHandler
{

    public function register(){
        
        $this->renderable(function (Exception $e, Request $request) {
            return response()->view('errors.invalid-request', [], 500);
        });
    }
    
   
   
}
