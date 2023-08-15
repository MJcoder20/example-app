<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Passport\Client as OClient;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Bridge\Scope;
use League\OAuth2\Server\CryptKey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Bridge\AccessToken;
use App\Http\Requests\ManageUsersRequest;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\Events\RefreshTokenCreated;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;


class AuthController extends Controller
{

    public function getTokenAndRefreshToken(OClient $oClient, $email, $password) { 
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;
        $response = $http->request('POST', 'http://127.0.0.1:8000/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => '*',
            ],
        ]);
        $result = json_decode((string) $response->getBody(), true);
        return response()->json($result, 200);
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

        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient, $validated['email'], $validated['password']);


          // $http = new Client;
        // $response = $http->post('http://127.0.0.1:8000/oauth/token', [
        //     'grant_type' => 'password',
        //     'client_id' => '4',
        //     'client_secret' => 'aBM6wQWaH8jb8o0rihMqhFzF4pWwaCaUMimmMHoK',
        //     'username' => $validated['email'],
        //     'password' => $validated['password'],
        //     'scope' => '',
        // ]);

        // $result = json_decode($response->getBody(), true);
        // if (!$response) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }
        
        // return response()->json($result);

        // $client = DB::table('oauth_clients')
        // ->where('password_client', true)
        // ->get()[0];
        // $data = [
        //     'grant_type' => 'password',
        //     'client_id' => $client->id,
        //     'client_secret' => $client->secret,
        //     'username' => $user->username,
        //     'password' => 'what-is-your-password', // just leave whatever string
        //     'scope' => '',
        // ];
        // $response = Request::create(url('/oauth/token'), 'POST', $data);
        // return json_decode(app()->handle($response)->getContent());



        // $token = new AccessToken($user->id);
        // $token->setIdentifier(generateUniqueIdentifier());
        // $token->setClient(new Client(2, null, null));
        // $token->setExpiryDateTime(Carbon::now()->addDay());
        // $token->addScope(new Scope('activity'));
        // $privateKey = new CryptKey('file://'.storage_path('oauth-private.key'));

        // $accessTokenRepository = new AccessTokenRepository(new TokenRepository, new Dispatcher);
        // $accessTokenRepository->persistNewAccessToken($token);

        // $jwtAccessToken = $token->convertToJWT($privateKey);
        // $responseParams = [
        //     'token_type'   => 'Bearer',
        //     'expires_in'   => $expireDateTime - (new \DateTime())->getTimestamp(),
        //     'access_token' => (string) $jwtAccessToken,
        //     'user'         => $user->toArray()
        // ];



    //     $token = $user->createToken('access_token');
    //     $refreshToken = $user->createToken('refresh-token');
    //     DB::table('oauth_access_tokens')->where('user_id',$user->id)
    //     ->where('name','refresh-token')->update([
    //         'expires_at'=>now()->addHours(5)
    //     ]);

    //     $response = [
    //         'message' => 'User Logged In Successfully',
    //         'user'=>$user,
    //         'access_token'=>$token->accessToken,
    //         'refresh_token'=>$refreshToken->accessToken,
    //         'token_type' => 'Bearer',
    //     ];

    //    return response($response,200);
        
    }




    public function register(ManageUsersRequest $request)
    {
        $validated = $request->validated();
        $validated['password']= Hash::make($validated['password']);

        $user = User::create($validated);
        $token = $user->createToken('access_token')->accessToken;
        $refreshToken = $user->createToken('refresh-token')->accessToken;
        DB::table('oauth_access_tokens')->where('user_id',$user->id)
        ->where('name','refresh-token')->update([
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
