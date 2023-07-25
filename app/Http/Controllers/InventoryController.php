<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Requests\InventoryRequest;

class InventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::filter(request()->all())->paginate(3);
        return view('inventories.index',['inventories'=>$inventories]);
    }

    

    public function create()
    {
        return view('inventories.create');
    }

    

    public function store(InventoryRequest $request)
    {
        $validated = $request->validated();

        Inventory::create($validated);
        return redirect('/inventories');
    }

   

    public function show(Inventory $inventory)
    {
        return view('inventories.show',['inventory'=>$inventory]);
    }

    

    public function edit(Inventory $inventory)
    {
        return view('inventories.edit',['inventory'=>$inventory]); 
    }

   
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'name'=>'string',
            'city_id'=>'integer',
            'is_active'=>'integer|min:0|max:1',
            'phone'=>'unique:inventories|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);
       

        $inventory->update($validated);
        return redirect('/inventories');
    }

    
    public function destroy(Inventory $inventory)
    {
      
        $inventory->delete();
        return redirect('/inventories');
    }
}
