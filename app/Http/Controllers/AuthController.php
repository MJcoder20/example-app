<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\ClientRepository;
use App\Http\Requests\ManageUsersRequest;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\RefreshTokenRepositoryInterface;

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

        $token = $user->createToken('access_token');

         // Create refresh token
        // $refreshToken = $user->createToken('refresh-token',[''],now()->addHours(5));
        
        // DB::table('oauth_refresh_tokens')->insert(['access_token_id'=>$token]);

     
        // Passport::refreshToken()->create(['access_token_id'=>$token->id,]);

        // $http = new Client;

        // $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        //     'form_params' => [
        //         'grant_type' => 'refresh_token',
        //         'refresh_token' => 'the-refresh-token',
        //         'client_id' => 'client-id',
        //         'client_secret' => 'client-secret',
        //         'scope' => '',
        //     ],
        // ]);

        // return json_decode((string) $response->getBody(), true);


        $response = [
            'message' => 'User Logged In Successfully',
            'user'=>$user,
            'access_token'=>$token->accessToken,
            // 'refresh_token'=>$refreshToken->accessToken,
            'token_type' => 'Bearer',
        ];

       return response($response,200);

    }




    public function register(ManageUsersRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken('access_token')->accessToken;

        $response = [
            'message' => 'User created Successfully',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response($response,201);
    
    }


    

    public function reset(Request $request){
        $validated =$request->validate([
            'email' => 'required|email',
            'password' => 'required|string|same:confirm_password',
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();

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
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->update([
            'revoked'=>true
        ]);
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
       
    }




    public function refresh(Request $request)
    {
        // $user = User::find(Auth::id());
        $user = $request->user();
     
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();
        $token = $user->createToken('access_token');
    
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token->accessToken,
                'type' => 'bearer',
            ]
        ]);
    }




}
