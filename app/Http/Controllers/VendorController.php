<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorController extends Controller
{
    
    use SoftDeletes;
    
    public function index()
    {
        $vendors = Vendor::filter(request()->all())->get();

        return view('vendors.index', ['vendors'=>$vendors]);
    
    }

   
    public function create()
    {
        if(Auth::user()->is_admin==1){
            return view('vendors.create');
        }
    }

   
    public function store(VendorRequest $request)
    {
       
        $validated = $request->validated();
        Vendor::create($validated);

        return redirect('/vendors');

    }

    
    public function edit(Vendor $vendor)
    {
        if(Auth::user()->is_admin==1){
            return view('vendors.edit',['vendor'=>$vendor]);
        }
    }

    public function update(VendorRequest $request, Vendor $vendor){

        $validated= $request->validated();
        
        $vendor->update($validated);

        return redirect('/vendors');
    }

 
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect('/vendors');
   }

}
