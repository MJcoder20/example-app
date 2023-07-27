<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::filter(request()->all())->paginate(3);
        return view('items.index',['items'=>$items]);
    }


    public function items(){
        $items = Item::filter(request()->all())->get();
        return view('items',['items'=>$items]);
    }


    public function cart(){
        return view('cart');
    }

    public function add_to_cart(Item $item){
        $item = DB::select('select * from items where id='.$item->id);
        $quantity = DB::select('select * from inventory_items where item_id='.$item[0]->id);


        $cart = Session::get('cart');
        $cart[] = array(
            "id" => $item[0]->id,
            "name" => $item[0]->name,
            "image" => $item[0]->image,
            // "price"=>30,
            "quantity" => 1,
        );

        Session::put('cart', $cart);
        Session::flash('success','Item added to cart successfully!');
        //dd(Session::get('cart'));
        return redirect()->back();
    }


    // public function add_to_cart(Item $item){
    //     $item = DB::select('select * from items where id='.$item->id);
    //     // $item = Item::find($item[0]->id);
    //     if(!$item[0]) {
    //         abort(404);
    //     }
    //     $cart = session()->get('cart');
     
    //     if(!$cart) {
    //         $cart = [
    //             $item[0]->id => [
    //                 "name" => $item[0]->name,
    //                 "photo" => $item[0]->image,
    //                 "quantity" => 1,
    //                 // "price" => $product->price,
                    
    //             ]
    //         ];
    //         session()->put('cart', $cart);
    //         return redirect()->back()->with('success', 'Item added to cart successfully!');
    //     }

    //     if(isset($cart[$item[0]->id])) {
    //         $cart[$item[0]->id]['quantity']++;
    //         session()->put('cart', $cart);
    //         return redirect()->back()->with('success', 'Item added to cart successfully!');
    //     }

    //     $cart[$item[0]->id] = [
    //         "item" => $item[0]->name,
    //         "quantity" => 1,
    //         "photo" => $item[0]->image,
    //         // "price" => $item->price,
            
    //     ];
    //     session()->put('cart', $cart);
    //     return redirect()->back()->with('success', 'Item added to cart successfully!');
    // }


    public function updateCart(Request $cartdata)
    {
        $cart = Session::get('cart');

        $cartQuantity = 1;

        foreach ($cartdata->all() as $id => $val) 
        {
            if ($cartQuantity != 1) {
                $cart[$id]['quantity'] = $val;
                if ($val < 1) {
                    unset($cart[$id]);
                }
            }
            $cartQuantity++;
        }
        Session::put('cart', $cart);
        return redirect()->back();
    }


    public function deleteCartItem($id)
    {
        $cart = Session::get('cart');
        unset($cart[$id]);
        Session::put('cart', $cart);
        return redirect()->back();
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

        if($request->file('image')){
            $image=$request->file('image');
            $imageName = 'item-image' . '-' .time().'.'.$image->getClientOriginalExtension();  
            $image->move(public_path('images'), $imageName);
            $validated['image']=$imageName;
        }
        

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
        return view('items.show',['item'=>$item]);
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
            'name'=>'string',
            'image'=>'nullable|file|mimes:png,jpg,jpeg',
            'brand_id' => [ 'integer', Rule::unique('items')->where(function ($query) use ($request) {
                return $query->where('name', $request->input('name'));
            })->ignore($item->id)],
            'is_active'=>'integer|min:0|max:1',
        ]);
       
        if($request->file('image')){
            $image=$request->file('image');
            $imageName = 'item-image' . '-' .time().'.'.$image->getClientOriginalExtension();  
            $image->move(public_path('images'), $imageName);
            $validated['image']=$imageName;
        }
       

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
        $path=public_path('images/');
        unlink($path.$item->image);
        $item->delete();
        return redirect('/items');
    }
}
