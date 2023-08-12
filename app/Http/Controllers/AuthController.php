<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\UserLogin;
use App\Enums\TokenAbility;
use Laravel\Passport\Token;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\RefreshToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ManageUsersRequest;


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


        $token = $user->createToken('access_token')->accessToken;

        // $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API], config('sanctum.expiration'))->accessToken;
        // $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN], config('sanctum.rt_expiration'))->accessToken;

        $response = [
            'message' => 'User Logged In Successfully',
            'user'=>$user,
            'access_token'=>$token,
            // 'access_token' => $accessToken,
            // 'refresh_token' => $refreshToken,
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
        // $token = $user->createToken('access_token',[TokenAbility::ACCESS_API], config('sanctum.expiration'))->accessToken;
        // $user->remember_token = $token;
        // $user->save();

        $response = [
            'message' => 'User created Successfully',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return response($response,200);
    
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
        $user = User::find(Auth::id());
        
        if($user){
            $request->user()->token()->revoke();
            // $request->user()->AauthAcessToken()->delete();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        }
        return response()->json([
            'message' => 'What user!',
        ]);
    }




    public function refresh()
    {
        $user = User::find(Auth::id());
        $accessToken=$user->token();
        // $user->AauthAcessToken()->delete();
        // DB::table('oauth_refresh_tokens')
        // ->where('access_token_id', $accessToken->id)
        // ->update([
        //     'revoked' => true
        // ]);
        $accessToken->revoke();
        $token = $user->createToken('access_token')->accessToken;
        // $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API], config('sanctum.expiration'))->accessToken;
    
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                // 'access_token' => $accessToken,
                'type' => 'bearer',
            ]
        ]);
    }
}
