<?php

namespace App\Http\Controllers\API;

use App\Events\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Modules\User\App\Models\User;
use App\Http\Requests\ManageUsersRequest;
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

        $token = $user->createToken('access_token');
        $refreshToken = $user->createToken('refresh_token');
        DB::table('oauth_access_tokens')->where('user_id',$user->id)
        ->where('name','refresh_token')->update([
            'expires_at'=>now()->addHours(5)
        ]);

        $response = [
            'message' => 'User Logged In Successfully',
            'user'=>$user,
            'access_token'=>$token->accessToken,
            'refresh_token'=>$refreshToken->accessToken,
            'token_type' => 'Bearer',
        ];

       return response($response,200);
        
    }




    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken('access_token')->accessToken;
        $refreshToken = $user->createToken('refresh_token')->accessToken;
        DB::table('oauth_access_tokens')->where('user_id',$user->id)
        ->where('name','refresh_token')->update([
            'expires_at'=>now()->addHours(5)
        ]);

        $response = [
            'message' => 'User created Successfully',
            'user'=>$user,
            'access_token' => $token,
            'refresh_token'=>$refreshToken,
            'token_type' => 'Bearer',
        ];

        return response($response,201);
    
    }


    

    public function reset(Request $request){

        $this::refresh($request);
        
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
        $this::refresh($request);
        $user = $request->user();
        DB::table('oauth_access_tokens')->where('user_id',$user->id)->delete();

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
       
    }




    public static function refresh(Request $request)
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
            ->where('name','refresh_token')->update([
                'expires_at'=>now()->addHours(5)
            ]);

           
     
        // return response()->json([
        //     'user' => $user,
        //     'tokens'=>$tokens,
        // ]);
        
        
    }




}
