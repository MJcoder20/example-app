<?php

namespace App\Http\Controllers\API;

use App\Events\UserLogin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Modules\User\App\Models\User;
use Laravel\Passport\Client as OClient;
use Laravel\Socialite\Facades\Socialite;
use App\Modules\User\App\Http\Requests\UserRequest;



class AuthController extends Controller
{

    protected function _registerOrLoginUser($data){
        // $user = User::where('email',$data->email)->first();
        //   if(!$user){
        //      $user = new User();
        //      $user->name = $data->name;
        //      $user->username = $data->username;
        //      $user->email = $data->email;
        //      $user->provider_id = $data->id;
        //      $user->avatar = $data->avatar;
        //      $user->save();
        //   }
            // Auth::login($user);

            $user = User::where('email',$data->email)->first();
            if(!$user){
                $user = new User();
                $user->full_name = $data->name;
                $name = explode(' ',$data->name);
                $user->first_name = $name[0];
                $user->last_name = $name[1];
                $user->username = $data->username;
                $user->email = $data->email;
                $user->provider_id = $data->id;
                $user->avatar = $data->avatar;
                $user->save();
            }
            // $this->login($user);
            Auth::login($user);
           
    }

    
    //Facebook Login
    public function redirectToFacebook(){
        return Socialite::driver('facebook')->stateless()->redirect();
    }
    
    //facebook callback  
    public function handleFacebookCallback(){
    
        $user = Socialite::driver('facebook')->stateless()->user();
    
        $this->_registerorLoginUser($user);
        return redirect('/');
    }
    
    //Github Login
    public function redirectToGithub(){
        return Socialite::driver('github')->stateless()->redirect();
    }
    
    //github callback  
    public function handleGithubCallback(){
    
        $user = Socialite::driver('github')->stateless()->user();
       
        $this->_registerorLoginUser($user);
        return redirect('/');
    }


    public function login(Request $request)
    {
        $validated =$request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();

        if(!$user || !Hash::check($validated['password'], $user->password)){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        event(new UserLogin($user));

        $oClient = OClient::where('password_client', 1)->first();
        $params = [
        
            'grant_type' => 'password',
            'client_secret'   => $oClient->secret,
            'client_id'   => $oClient->id,
            'username' => $validated['email'],
            'password' => $validated['password'],
        ];

        $request = Request::create('/oauth/token', 'POST', $params);
        $user->api_token = STR::random(80);
        $user->save();

        return app()->handle($request); 
        
    }




    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);

        $oClient = OClient::where('password_client', 1)->first();
        $params = [
         
            'grant_type' => 'password',
            'client_secret'   => $oClient->secret,
            'client_id'   => $oClient->id,
            'username' => $user->email,
            'password' => $user->password,
        ];
    
        $request = Request::create('/oauth/token', 'POST', $params);
        $user->api_token = STR::random(80);
        $user->save();
    
        return app()->handle($request); 
    
    }


    

    public function reset(Request $request){
        
        $validated =$request->validate([
            'email' => 'required|email',
            'password' => 'required|string|same:confirm_password',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        // $token = $user->createToken('access_token')->accessToken;
        $access_token = DB::table('oauth_access_tokens')->where('user_id',$user->id)->where('revoked',false)->first();

        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', [$user->email,$user->api_token, now()]);

        return response()->json([
            'message' => 'User password reset Successfully',
            'user'=>$user,
            'access_token' => $access_token,
            'token_type' => 'Bearer',
        ],200);
    }




    public function logout(Request $request)
    {
        $user = $request->user();
        $access_token = DB::table('oauth_access_tokens')->where('user_id',$user->id)->first();
        DB::table('oauth_refresh_tokens')->where('access_token_id',collect($access_token)->get('id'))->delete();
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
        $user->api_token = null;
        $user->save();
        
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
       
    }




    public static function refresh(Request $request)
    {
        $user = $request->user();
        
        $access_token = DB::table('oauth_access_tokens')->where('user_id',$user->id)->where('revoked',false)->first();
        $refresh_token = DB::table('oauth_refresh_tokens')->where('access_token_id',collect($access_token)->get('id'))
        ->where('revoked',false)->first();

        if(collect($access_token)->get('expires_at') < now()){
            if(collect($refresh_token)->get('expires_at') < now()){
                DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
                DB::table('oauth_refresh_tokens')->where('access_token_id',collect($access_token)->get('id'))->delete();
                $oClient = OClient::where('password_client', 1)->first();
                $params = [
                
                    'grant_type' => 'password',
                    'client_secret'   => $oClient->secret,
                    'client_id'   => $oClient->id,
                    'username' => $user->email,
                    'password' => $user->password,
                ];
            
                $request = Request::create('/oauth/token', 'POST', $params);
                return app()->handle($request); 
            }else{

                DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
                $access_token = $user->createToken('access_token');
                DB::table('oauth_refresh_tokens')->where('id',collect($refresh_token)->get('id'))
                ->update(['access_token_id'=>$access_token]);
            }
        }
     
        $user->api_token = Str::random(80);
        $user->save();

        return response()->json([
            'user' => $user,
            'access_token'=>$access_token,
            'refresh_token'=>$refresh_token
        ]);
        
        
        
    }




}
