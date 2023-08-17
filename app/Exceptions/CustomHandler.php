<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use App\Exceptions\Handler as ExceptionHandler;

class CustomHandler extends ExceptionHandler
{

    public function register(){
        
        $this->renderable(function (CustomException $e, Request $request) {
            return response()->view('errors.invalid-request', [], 500);
        });
    }
    
   
   
}
