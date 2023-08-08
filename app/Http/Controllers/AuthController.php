<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User Logged In Successfully',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);


    }




    public function register(ManageUsersRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->remember_token = $token;
        $user->save();

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

        $token = $user->createToken('auth_token')->plainTextToken;

        $user->password = Hash::make($validated['password']);
        // $user->remember_token = $token;
        $user->save();

        DB::insert('insert into password_resets (email, token, created_at) values (?, ?, ?)', [$user->email,$token, Carbon::now()]);

        return response()->json([
            'message' => 'User password reset Successfully',
            'user'=>$user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }




    public function logout()
    {
        $user = User::find(Auth::id());
        $user->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }




    public function refresh()
    {
        $user = User::find(Auth::id());
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}
