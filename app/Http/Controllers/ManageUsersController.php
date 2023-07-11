<?php

namespace App\Http\Controllers;

use App\Models\ManageUsers;
use Illuminate\Http\Request;
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

   
    public function store(Request $request)
    {
        $validated = $this->validate($request,[
                'username'=>'required|min:5',
                'email'=>'required|email',
                'first_name'=>'min:3|max:15',
                'last_name'=>'min:3|max:15',   
                'is_admin'=>'0|1',
                'is_active'=>'0|1',
                'password'=>'required|min:9|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
            ]);

        $validated['password']=bcrypt($validated['password']);

        ManageUsers::create($validated);

        return redirect('/');

    }

    
    public function edit(ManageUsers $user)
    {
        return view('edit',['user'=>$user]);
    }

    public function update(Request $request, ManageUsers $user){

        $validated = $this->validate($request,[
            'username'=>'required|min:5',
            'email'=>'required|email',
            'first_name'=>'min:3|max:15',
            'last_name'=>'min:3|max:15',     
            'is_admin'=>'0|1',
            'is_active'=>'0|1',
            'password'=>'required|min:9|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
        ]);

        $validated['password']=bcrypt($validated['password']);

        $user->update($validated);

        return back();
    }


   
    public function destroy(ManageUsers $user)
    {
        $user->delete();
        return redirect('/');
   }

}
