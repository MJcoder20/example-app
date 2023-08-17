<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    
    


    public function render(Request $request): Response
    {
        $status = 400;
        $error = "Something went wrong";
        $help = "Contact the IT support team for assistance";

        return response(["error" => $error, "help" => $help], $status);
    }

   
    
}
