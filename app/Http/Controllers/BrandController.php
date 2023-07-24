<?php

namespace App\Http\Controllers;

use App\Models\Brand;


// use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Image;
use App\Http\Requests\BrandRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::filter(request()->all())->get();
        
        return view('brands.index',['brands'=>$brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('icon')){
            $icon=$request->file('icon');
            $iconName = 'brand-icon' . '-' . time().'.'.$icon->getClientOriginalExtension();  
            $icon->move(public_path('images'), $iconName);
        }
        $validated['icon']=$iconName;

        
        Brand::create($validated);
        return redirect('/brands');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        if(Auth::user()->is_admin==1){
            return view('brands.edit',['brand'=>$brand]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        
        $validated=$request->validated();
        $icon=$request->file('icon');
        if($icon){
            $iconName = time().'.'.$icon->getClientOriginalExtension();  
            $icon->move(public_path('images'), $iconName);
        }
        $validated['icon']=$iconName;

        $brand->update($validated);
        return redirect('/brands');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
 
        $brand->delete();
        return redirect('/brands');
    }
}
