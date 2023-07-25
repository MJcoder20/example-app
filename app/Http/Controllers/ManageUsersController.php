<?php

namespace App\Http\Controllers;

use App\Models\ManageUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ManageUsersRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManageUsersController extends Controller
{
    use SoftDeletes;
    
    public function index()
    {
        $users = ManageUsers::filter(request()->all())->paginate(3);
        // $users = ManageUsers::paginate(3);
        return view('users.index', ['users'=>$users]);
    
    }



   
    public function create()
    {

         return view('users.create');
     
    }

   
    public function store(ManageUsersRequest $request)
    {
       
        $fields = $request->validated();
        $fields['password']=bcrypt($fields['password']);

        ManageUsers::create($fields);

        return redirect('/');

    }

    
    public function edit(ManageUsers $user)
    {
        if(Auth::user()->is_admin==1){
            return view('users.edit',['user'=>$user]);
        }
    }

    public function update(Request $request, ManageUsers $user){

        $fields= $request->validate([
            'username'=>'required|min:5',
            'email'=>'required|email',
            'first_name'=>'min:3|max:15',
            'last_name'=>'min:3|max:15',   
            'is_admin'=>'integer|min:0|max:1',
            'is_active'=>'integer|min:0|max:1',
            'password'=>'required|same:confirm_password|min:9|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required'
        ]);
        
        $fields['password']=bcrypt($fields['password']);
        $user->update($fields);

        return redirect('/');
    }

 
    public function destroy(ManageUsers $user)
    {
        $user->delete();
        return redirect('/');
   }

}
