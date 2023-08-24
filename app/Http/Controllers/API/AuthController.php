<?php

namespace App\Http\Controllers\API;

use App\Events\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Modules\User\App\Models\User;
use Laravel\Passport\Client as OClient;
use App\Modules\User\App\Http\Requests\UserRequest;



class AuthController extends Controller
{

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

        $token = $user->createToken('access_token')->accessToken;

        $user->password = Hash::make($validated['password']);
        $user->save();

        DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', [$user->email,$token, now()]);

        return response()->json([
            'message' => 'User password reset Successfully',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ],200);
    }




    public function logout(Request $request)
    {
        $user = $request->user();
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
        $access_token = DB::table('oauth_access_tokens')->where('user_id',$user->id)->where('revoked',false)->first();
        DB::table('oauth_refresh_tokens')->where('access_token_id',collect($access_token)->get('id'))->delete();

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
     
        return response()->json([
            'user' => $user,
            'access_token'=>$access_token,
            'refresh_token'=>$refresh_token
        ]);
        
        
        
    }




}
