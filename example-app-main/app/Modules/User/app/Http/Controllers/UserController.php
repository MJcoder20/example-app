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
    
        if($request->user()->hasRole('Admin')){ 
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
            // return response()->apiPaginate($users);
            return view('User::users.index',['users'=>User::all()]);

        }else{
            return response()->msg([
                'message' => "You're not an admin!"
            ]);
        }
         
    }



    public function show(User $user, Request $request){
        
        // if(Auth::user()->is_admin==1){  
        if($request->user()->hasRole('Admin')){         
            return response()->api(new UserResource($user));
        }else{
            return response()->api([
                'message' => "You're not an admin!"
            ]);
        }
        // }else{
        //     return response()->msg([
        //         'message' => "You're not an admin"
        //     ]);
        // }
    }



    public function search(Request $request){
        if($request->user()->hasRole('Admin')){ 
            return User::search($request->input('search'))->withTrashed()->paginate(5);
        }else{
            return response()->api([
                'message' => "You're not an admin!"
            ]);
        }
    }
   

    public function create(){
        return view('User::users.create');
    }
   

    public function store(UserRequest $request){
        if($request->user()->hasRole('Admin')){ 
            $fields = $request->validated();
            
            $fields['password']=bcrypt($fields['password']);
            $user = User::create($fields);
            if($user->isAdmin==1){
                $user->assignRole('Admin');
            }else{
                $user->assignRole('User');
            }
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
            return response()->api([
                'message' => "You're not an admin!"
            ]);
        }

    }

    public function edit(User $user){
        return view('User::users.edit',['user' => $user]);
    }

    public function update(Request $request, User $user){
        if($user->hasRole('Admin')){ 
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
            if($user->isAdmin==1){
                $user->assignRole('Admin');
            }else{
                $user->assignRole('User');
            }
        
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
            return response()->api([
                'message' => "You're not an admin!"
            ]);
        }

    }

 
    public function destroy(User $user){
        if($user->hasRole('Admin')){ 
            Address::where('addressable_id',$user->id)->delete();
            $user->delete();

            return response()->msg([
                'message' => 'User Deleted Successfully',
            ]);
        }else{
            return response()->api([
                'message' => "You're not an admin!"
            ]);
        }
   }





}
