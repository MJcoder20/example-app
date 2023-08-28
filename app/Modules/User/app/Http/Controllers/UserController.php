<?php

namespace App\Modules\User\App\Http\Controllers;

use Session;
use App\Models\Address;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modules\User\App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\User\App\Http\Requests\UserRequest;
use App\Modules\User\App\Http\Resources\UserResource;

class UserController extends Controller
{
    use SoftDeletes;


    public function index(Request $request){

        if(Auth::user()->is_admin==1){
        // if(Auth::user()->hasRole('admin')){

            $redis = Redis::connection();
            if ($redis) {
                echo 'connection done';
            } else {
                echo 'connection not done';
            }

            $users = Cache::remember('all_users', 30, function () {
                return UserResource::collection(User::with('addresses')->paginate(5));
            });
            $users = Cache::get('all_users');

            // $users = UserResource::collection(User::with('addresses')->paginate(5));
            return response()->apiPaginate($users);
            // return view('User::users.index',['users'=>User::all()]);

        }else{
            return response()->msg([
                'message' => "You're not an admin"
            ]);
        }
         
    }



    public function show(User $user){
        
        if(Auth::user()->is_admin==1){     
            return response()->api(new UserResource($user));
        }else{
            return response()->msg([
                'message' => "You're not an admin"
            ]);
        }
    }



    public function search(Request $request){
        // return User::search($request->input('search'))->withTrashed()->paginate(5);
        return User::search($request->input('search'))->paginate(5);
    }
   

   
    public function store(UserRequest $request){

        if(Auth::user()->is_admin==1){
            // if(Auth::user()->hasRole('admin')){
            
            $fields = $request->validated();
            
            $fields['password']=bcrypt($fields['password']);
            $user = User::create($fields);
            // if($user->is_admin==1){
            //     $user->assignRole('admin');
            // }else{
            //     $user->assignRole('user');
            // }
            $user->api_token = Str::rand(80);
            $user->save();

            $address['addressable_id']=$user->id;
            $address['addressable_type']='App\Modules\User\App\Models\User';
            $address['district']=$request->district;
            $address['street']=$request->street;
            $address['phone']=$request->phone;
            $address['city_id']=$request->city_id;
            Address::create($address); 

            SendWelcomeEmail($user);
            
            return response()->api(new UserResource($user));

        }else{

            return response()->msg([
                'message' => "You're not an admin"
            ]);
            
        }

    }


    public function update(Request $request, User $user){

        if(Auth::user()->is_admin==1){

            $fields= $request->validate([
                'username'=>'required|min:5',
                'email'=>'required|email',
                'first_name'=>'min:3|max:15',
                'last_name'=>'min:3|max:15', 
                'is_admin'=>'integer|min:0|max:1',
                'is_active'=>'integer|min:0|max:1',
                'password'=>'required|same:confirm_password|min:9|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
                'confirm_password' => 'required',
            ]);
            
            $fields['password']=bcrypt($fields['password']);
            $user->update($fields);
        
            $address['addressable_id']=$user->id;
            $address['addressable_type']='App\Modules\User\App\Models\User';
            $address['district']=$request->district;
            $address['street']=$request->street;
            $address['phone']=$request->phone;
            $address['city_id']=$request->city_id;

           if($request->district && $request->street && $request->phone && $request->city_id){
                $addr=Address::where('addressable_id',$user->id);
                $addr->update($address);
           }
   
            return response()->api(new UserResource($user));

        }else{
            return response()->msg([
                'message' => "You're not an admin"
            ]);
        }
    }

 
    public function destroy(User $user){

        if(Auth::user()->is_admin==1){

            Address::where('addressable_id',$user->id)->delete();
            $user->delete();

            return response()->msg([
                'message' => 'User Deleted Successfully',
              
            ]);

        }else{
            return response()->msg([
                'message' => "You're not an admin"
            ]);
        }
   }

}
