<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLoginNotification
{
    /**
     * Create the event listener.
     *
     * @param  Request  $request
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Login  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
        $current_timestamp = Carbon::now()->toDateTimeString();

        $user = $event->user;

        $saveLoginHistory = DB::table('login_history')->insert([
            'name'=>$user->username,
            'email' => $user->email,
            'created_at'=>$current_timestamp
        ]);

        return $saveLoginHistory;
     
    }
}
