<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\ItemRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::filter(request()->all())->get();
        return view('items.index',['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
          
            'name'=>'required|string',
            'image'=>'file|mimes:png,jpg,jpeg',
            // 'brand_id'=>'integer',
            'brand_id' => ['required', 'integer', Rule::unique('items')->where(function ($query) use ($request) {
                return $query->where('name', $request->input('name'));
            })],
            'is_active'=>'integer|min:0|max:1',
        ]);


        $image=$request->file('image');
        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();  
            $image->move(public_path('images'), $imageName);
        }
        $validated['image']=$imageName;

        Item::create($validated);
        return redirect('/items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
       
         return view('items.edit',['item'=>$item]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'=>'required',
            'image'=>'file|mimes:png,jpg,jpeg',
            'brand_id' => ['required', 'integer', Rule::unique('items')->where(function ($query) use ($request) {
                return $query->where('name', $request->input('name'));
            })],
            'is_active'=>'integer|min:0|max:1',
        ]);
       

        $image=$request->file('image');
        if($image){
            $imageName = time().'.'.$image->getClientOriginalExtension();  
            $image->move(public_path('images'), $imageName);
        }
        $validated['image']=$imageName;

        $item->update($validated);
        return redirect('/items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect('/items');
    }
}
