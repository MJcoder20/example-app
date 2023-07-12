<?php

namespace App\Http\Controllers;

use App\Models\ManageUsers;
use Illuminate\Http\Request;
use App\Http\Requests\ManageUsersRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageUsersController extends Controller
{
    use SoftDeletes;
    
    public function index()
    {
        $users = ManageUsers::paginate();
        return view('index', ['users'=>$users]);
    }

   
    public function create()
    {
        return view('create');
    }

   
    public function store(ManageUsersRequest $request)
    {
        // $fields = $request->validate([
        //         'username'=>'required|unique:manage_users|min:5',
        //         'email'=>'required|email',
        //         'first_name'=>'min:3|max:15',
        //         'last_name'=>'min:3|max:15',   
        //         'is_admin'=>'0|1',
        //         'is_active'=>'0|1',
        //         'password'=>'required|min:9|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        //     ]);

        $fields = $request->validated();
        $fields['password']=bcrypt($fields['password']);

        ManageUsers::create($fields);

        return redirect('/');

    }

    
    public function edit(ManageUsers $user)
    {
        return view('edit',['user'=>$user]);
    }

    public function update(ManageUsersRequest $request, ManageUsers $user){

        // $fields = $request->validate([
        //     'username' => 'required|unique:manage_users|min:5',
        //     'email'=>'required|email',
        //     'first_name'=>'min:3|max:15',
        //     'last_name'=>'min:3|max:15',     
        //     'is_admin'=>'0|1',
        //     'is_active'=>'0|1',
        //     'password'=>'required|min:9|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        // ]);

        $fields = $request->validated();
        $fields['password']=bcrypt($fields['password']);

        $user->update($fields);

        return back();
    }


   
    public function destroy(ManageUsers $user)
    {
        $user->delete();
        return redirect('/');
   }

}
