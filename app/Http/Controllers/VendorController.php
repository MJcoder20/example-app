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
        $vendors = Vendor::filter(request()->all());

        return view('vendors.index', ['vendors'=>$vendors]);
    
    }

   
    public function create()
    {
        return view('vendors.create');
       
    }

   
    public function store(VendorRequest $request)
    {
       
        $fields = $request->validated();

        Vendor::create($fields);

        return redirect('/vendors');

    }

    
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit',['vendor'=>$vendor]);
        
    }

    public function update(VendorRequest $request, Vendor $vendor){

        $fields= $request->validated();
        
        $vendor->update($fields);

        return redirect('/vendors');
    }

 
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return redirect('/vendors');
   }

}
