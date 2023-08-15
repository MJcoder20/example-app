<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ManageUsersRequest;
use App\Http\Controllers\API\AuthController;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserController extends Controller
{
    use SoftDeletes;
    
    public function index()
    {
        AuthController::refresh(request());

        $users = User::filter(request()->all())->get();

        // $i=0;$all=[];
        if(Auth::user()->is_admin==1){
            foreach($users as $user){
                $user->setFullName($user->first_name,$user->last_name);
                $user->setAddresses($user->userAddresses());
                // $all[$i]['Full Name']=$user->getFullName();
                // $all[$i]['addresses']=$user->getAddresses();
                // $i++;
            }

            return response()->json([
                'Users'=>$users,
                // 'Users'=>$all
            ]);

        }else{
            return response()->json([
                'message'=>"You're not an admin"
            ]);
        }
        
         
    }



    public function show(User $user){
        
        if(Auth::user()->is_admin==1){
            AuthController::refresh(request());
            
            $user->setFullName($user->first_name,$user->last_name);
            $user->setAddresses($user->userAddresses());
            return response()->json([
                'User'=>$user,
               
            ]);
        }else{
            return response()->json([
                'message'=>"You're not an admin"
            ]);
        }
    }
   
   
    public function store(Request $request)
    {
        if(Auth::user()->is_admin==1){
            AuthController::refresh($request);
            
            $fields = $request->validate([
                'username'=>'required|unique:manage_users|min:5',
                'email'=>'required|email|unique:manage_users',
                'first_name'=>'min:3|max:15',
                'last_name'=>'min:3|max:15', 
                'password'=>'required|same:confirm_password|min:9|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
                'confirm_password' => 'required',
            ]);
            
            $fields['password']=bcrypt($fields['password']);
            $user = User::create($fields);
            $user->setFullName($fields['first_name'],$fields['last_name']);

            $address['addressable_id']=$user->id;
            $address['addressable_type']='App\Models\User';
            $address['district']=$request->district;
            $address['street']=$request->street;
            $address['phone']=$request->phone;
            $address['city_id']=$request->city_id;
            Address::create($address);
            $user->setAddresses($user->userAddresses());


            return response()->json([
                'message' => 'User Created Successfully',
                'User' => $user,

            ],200);

        }else{
            return response()->json([
                'message' => "You're not an admin",
            ]);
        }

    }


    public function update(Request $request, User $user){

        if(Auth::user()->is_admin==1){
            AuthController::refresh($request);

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
            $user->setFullName($fields['first_name'],$fields['last_name']);

        
            $address['addressable_id']=$user->id;
            $address['addressable_type']='App\Models\User';
            $address['district']=$request->district;
            $address['street']=$request->street;
            $address['phone']=$request->phone;
            $address['city_id']=$request->city_id;

           if($request->district && $request->street && $request->phone && $request->city_id){
                $addr=Address::where('addressable_id',$user->id);
                $addr->update($address);
           }
           $user->setAddresses($user->userAddresses());

            return response()->json([
                'message' => 'User Updated Successfully',
                'User' => $user,
              
            ],200);

        }else{
            return response()->json([
                'message' => "You're not an admin",
            ]);
        }
    }

 
    public function destroy(User $user)
    {
        if(Auth::user()->is_admin==1){
            AuthController::refresh(request());

            Address::where('addressable_id',$user->id)->delete();
            $user->delete();

            return response()->json([
                'message' => 'User Deleted Successfully',
              
            ],200);

        }else{
            return response()->json([
                'message' => "You're not an admin",
            ]);
        }
   }

}
