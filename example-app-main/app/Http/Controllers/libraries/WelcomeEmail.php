<?php 

use App\Jobs\SendWelcomeEmail;

function SendWelcomeEmail($user){
    SendWelcomeEmail::dispatch($user);
}


?>