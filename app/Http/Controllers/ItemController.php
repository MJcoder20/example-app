<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\VendorNotification;
use Illuminate\Database\Eloquent\Builder;


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


    public function items(){
        $items = Item::filter(request()->all())->get();
        return view('items',['items'=>$items]);
    }


    public function cart(){
        return view('cart');
    }



    public function add_to_cart(Item $item){

        $item = Item::find($item->id);
        if(!$item) {
            abort(404);
        }
        $cart = session()->get('cart');
     

        if(!$cart) {
            DB::insert('insert into sessions (item, quantity) values (?, ?)', [$item->name, 1]);
            
            $cart = [
                $item->id => [
                    "name" => $item->name,
                    "image" => $item->image,
                    "quantity" => 1,
                    "price" => $item->price,
                    
                ]
            ];

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item added to cart successfully!');    
        }

         

        if(isset($cart[$item->id])) {
            $name = $cart[$item->id]['name'];
            $quantity = ++$cart[$item->id]['quantity'];
          
            DB::update('update sessions set quantity = ? where item = ?', [$quantity,$name]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item added to cart successfully!');
        }

        $cart[$item->id] = [
            "name" => $item->name,
            "quantity" => 1,
            "image" => $item->image,
            "price" => $item->price,
            
        ];

        DB::insert('insert into sessions (item, quantity) values (?, ?)', [$item->name, 1]);

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }


    public function updateCart(Request $request,Item $item)
    {
        $cart = Session::get('cart');

        $cartQuantity = $request->input('quantity');

        DB::update('update sessions set quantity = ? where item = ?', [$cartQuantity,$item->name]);

        if ($cartQuantity != 1) {
            $cart[$item->id]['quantity'] = $cartQuantity;
            if ($cartQuantity < 1) {
                unset($cart[$item->id]);
            }
        }

        Session::put('cart', $cart);
        return redirect()->back();
    }


    public function deleteCartItem(Item $item)
    {
        $cart = Session::get('cart');
        DB::delete('delete from sessions where id='.$item->id);
        // DB::table('sessions')->where('id', $item->id)->delete();
        unset($cart[$item->id]);
        Session::put('cart', $cart);
        return redirect()->back();
    }


    public function purchaseItem(Item $item,int $count){

        $quantity = DB::table('items')
        ->join('vendor_items','items.id','=','vendor_items.item_id')
        ->where('vendor_items.item_id','=',$item->id)
        ->where('vendor_items.quantity','=','select max(quantity) from inventory_items')->get();

        $vendor_id = DB::table('vendor_items')
        ->where('vendor_items.item_id', '=', $item->id)
        ->where('vendor_items.quantity', '=', $quantity)
        ->select('vendor_items.vendor_id')->get();

        $item = Item::findOrFail($item->id);
        $vendor = Vendor::findOrFail($vendor_id);

        $quantity = DB::table('items')
        ->join('inventory_items','items.id','=','inventory_items.item_id')
        ->where('inventory_items.quantity','=','select max(quantity) from inventory_items')->get();

        if ($quantity < 50) {
            // Send the email notification to the vendor
            $vendor->notify(new VendorNotification($item));
            if($quantity==0){
                echo "There are no items in the inventory";
            }
        }

        DB::table('items')
        ->join('inventory_items', 'items.id', '=', 'inventory_items.item_id')
        ->where('items.id', '=', $item->id)
        ->join('inventories','inventory_items.inventory_id','=','inventories.id')
        ->where('inventory_items.quantity','=','select max(quantity) from inventory_items')
        ->update(
        [
            'inventory_items.quantity'=>$quantity-$count
        ]);

        $purchases = DB::table('items')->where('items.id', '=', $item->id)->select('items.total_purchases')->get();
        $price = DB::table('items')->where('items.id', '=', $item->id)->select('items.price')->get();


        DB::table('items')->where('items.id', '=', $item->id)
        ->update([
            'items.total_purchases'=>$purchases+$count
        ]);

        $newPurchases = DB::table('items')->where('items.id', '=', $item->id)->select('items.total_purchases')->get();

        DB::table('items')->where('items.id', '=', $item->id)
        ->update([
            'items.total_sales'=>$newPurchases*$price
        ]);
   

    }

    public function purchase(){
     
        $items = DB::table('sessions')->select('items.*')->get();

        foreach($items as $item){
            $this->purchaseItem($item, $item->quantity);
        }
        
        return response()->json(['message' => 'Purchase completed successfully']);
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
            'available'=>'integer|min:0|max:1',
            'price'=>'required|float|min:1',
            'total_purchases'=>'integer|min:0',
            'total_sales'=>'float|min:0',
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
            'available'=>'integer|min:0|max:1',
            'price'=>'float|min:1',
            'total_purchases'=>'integer|min:0',
            'total_sales'=>'float|min:0',
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
