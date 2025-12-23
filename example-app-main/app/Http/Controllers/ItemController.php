<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Inventory;
use App\Jobs\SendEmailJob;
use App\Models\VendorItem;
use App\Models\ManageUsers;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\PurchaseOrder;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Modules\User\App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Mail\LowItemQuantityNotification;
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
        $brands = Brand::filter(request()->all())->get();
        $vendors = Vendor::filter(request()->all())->get();
        $inventories = Inventory::filter(request()->all())->get();
        return view('items',['items'=>$items,'brands'=>$brands,
        'vendors'=>$vendors,'inventories'=>$inventories]);
    }


    public function cart(){
        return view('cart');
    }


    public function sendMail(Item $item,Vendor $vendor){
        Mail::to($vendor->email)
            ->queue(new LowItemQuantityNotification($item));
        return "An email was sent to the vendor.";
    }


    public function add_to_cart(Item $item){

        $inven_items = DB::table('inventory_items')
            ->where('item_id', '=', $item->id)
            ->orderByDesc('quantity')
            ->first();
        
        $quantity=collect($inven_items)->get('quantity');
     
        $vendors= DB::table('vendor_items')
        ->where('item_id', '=', $item->id)
        ->where('quantity', '=', $quantity)
        ->get();

        foreach($vendors as $v){
            $vendor = Vendor::find(collect($v)->get('vendor_id'));
            // check if quantity of items is less than 50 to notify vendor
      
            if ($quantity < 50 && $vendor->is_active==1) {        
                $this->sendEmail($vendor);
            if($quantity==0){
                echo "There are no items in the inventory";
                $item->available=0;
                $item->save();
            }
            }
            
        } 

        if(!$item || $item->available==0) {
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
            return redirect()->back()->with('message', 'Item added to cart successfully!');    
        }
        if(isset($cart[$item->id])) {
            $name = $cart[$item->id]['name'];
            $quantity = ++$cart[$item->id]['quantity'];       
            DB::update('update sessions set quantity = ? where item = ?', [$quantity,$name]);
            session()->put('cart', $cart);
            return redirect()->back()->with('message', 'Item added to cart successfully!');
        }

        $cart[$item->id] = [
            "name" => $item->name,
            "quantity" => 1,
            "image" => $item->image,
            "price" => $item->price,
            
        ];
        DB::insert('insert into sessions (item, quantity) values (?, ?)', [$item->name, 1]);
        session()->put('cart', $cart);
        return redirect()->back()->with('message', 'Item added to cart successfully!');
    }


    public function updateCart(Request $request,Item $item){
    
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
        return redirect()->back()->with('message','Item quantity updated');
    }


    public function deleteCartItem(Item $item)
    {
        $cart = Session::get('cart');
        DB::delete('delete from sessions where id='.$item->id);
        unset($cart[$item->id]);
        Session::put('cart', $cart);
        return redirect()->back()->with('message','Item removed from cart successfully');
    }

    

    public function purchase(){

        $cartItems = DB::table('sessions')->get();

        foreach($cartItems as $cartItem){
            $it=DB::table('items')->where('name',$cartItem->item)->first();              
            $item = Item::find($it->id);

            //get max quantity
            $inven_items = DB::table('inventory_items')
            ->where('item_id', '=', $item->id)
            ->orderByDesc('quantity')
            ->first();        
     
            $inventory =Inventory::find(collect($inven_items)->get('inventory_id')); 
            $user = User::find(Auth::id()); 
        
            if($item!=null && $inventory!=null && $user!=null){
                $user->items()->attach($item->id,['inventory_id'=>$inventory->id]);
            }                   
                 
        } 

       
        DB::delete('delete from sessions ');
        Session::forget('cart');
        return redirect('/Items')->with('success','Purchase completed successfully!');
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
        return redirect('/items')->with('message','Item created successfully!');
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
        return redirect('/items')->with('message','Item updated successfully');
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
        return redirect('/items')->with('message','Item deleted successfully');
    }
}
