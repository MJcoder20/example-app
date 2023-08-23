<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Modules\User\App\Models\User;
use Laravel\Passport\Client as OClient;
use App\Modules\User\App\Http\Requests\UserRequest;


class AuthController extends Controller
{

    // public function getTokenAndRefreshToken(OClient $oClient, $email, $password) { 
    //     $oClient = OClient::where('password_client', 1)->first();
    //     $http = new Client;
    //     $response = $http->request('POST', 'http://127.0.0.1:8000/api/login/oauth/token', [
    //         'form_params' => [
    //             'grant_type' => 'password',
    //             'client_id' => $oClient->id,
    //             'client_secret' => $oClient->secret,
    //             'username' => $email,
    //             'password' => $password,
    //             'scope' => '*',
    //         ],
    //     ]);
    //     $result = json_decode((string) $response->getBody(), true);
    //     return response()->json($result, 200);
    // }


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


    //     $response = [
    //         'message' => 'User Logged In Successfully',
    //         'user'=>$user,
    //         'access_token'=>$token->accessToken,
    //         'refresh_token'=>$refreshToken->accessToken,
    //         'token_type' => 'Bearer',
    //     ];

    //    return response($response,200);
        
    }




    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken('access_token')->accessToken;
        // $refreshToken = $user->createToken('refresh-token')->accessToken;
        // DB::table('oauth_access_tokens')->where('user_id',$user->id)
        // ->where('name','refresh-token')->update([
        //     'expires_at'=>now()->addHours(5)
        // ]);

        $response = [
            'message' => 'User created Successfully',
            'user'=>$user,
            'access_token' => $token,
            // 'refresh_token'=>$refreshToken,
            'token_type' => 'Bearer',
        ];

        return response($response,201); 
    
    }


    

    public function reset(Request $request){

        $this->refresh($request);
        
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
        $this->refresh($request);
        $user = $request->user();
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
       
    }



    
    public function refreshToken(Request $request) { 

        $refresh_token = $request->header('Refreshtoken');
        $oClient = OClient::where('password_client', 1)->first();
      
        try {
            $params = [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'scope' => '*',
            ]; 
            $request = Request::create('/oauth/token', 'POST', $params);
            return app()->handle($request); 

        } catch (Exception $e) {
            return response()->json("unauthorized", 401); 
        }
    }




    public function refresh(Request $request)
    {

        $user = $request->user();
        
        $tokens = DB::table('oauth_access_tokens')->where('user_id',$user->id)->get();
        
        foreach($tokens as $token){
            if(collect($token)->get('expires_at') < now()){
                if(collect($token)->get('name')=='access_token'){
                    DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
                    $user->createToken('access_token')->accessToken;

                }else{
                    DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
                    $user->createToken('refresh_token')->accessToken;
                    
                }
            }  
        }

        DB::table('oauth_access_tokens')->where('user_id',$user->id)
                    ->where('name','refresh-token')->update([
                        'expires_at'=>now()->addHours(5)
                    ]);

           
     
        // return response()->json([
        //     'user' => $user,
        //     'tokens'=>$tokens,
        // ]);
        
        
    }




}
