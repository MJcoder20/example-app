@extends('layouts.layout')
@section('title', 'Items')
@section('content')
<section wire:id="Xj0uNwiURG74q0pEfJIG" class="padding-y">
<div class="row">
    <aside class="col-lg-3">
        
    
        <!-- ===== Card for sidebar filter ===== -->
        <div id="aside_filter" class="collapse card d-lg-block mb-5">
            <form action="">
                
            {{-- <article class="filter-group">
                <header class="card-header d-flex justify-content-between">
                    <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside2">
                        Price
                        <i class="fa fa-chevron-down float-right ms-1" aria-hidden="true"></i>
                    </a>
                                            </header>
                <div class="collapse show" id="collapse_aside2">
                    <div class="card-body">
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="0,25" type="radio" name="pricefilter" id="under25" wire:model="filters.price">
                            <label class="form-check-label ps-2" for="under25">
                                Under $25
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="25,50" type="radio" name="pricefilter" id="25to50" wire:model="filters.price">
                            <label class="form-check-label ps-2" for="25to50">
                                $25 to $50
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="50,100" type="radio" name="pricefilter" id="50to100" wire:model="filters.price">
                            <label class="form-check-label ps-2" for="50to100">
                                $50 to $100
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="100,200" type="radio" name="pricefilter" id="100to200" wire:model="filters.price">
                            <label class="form-check-label ps-2" for="100to200">
                                $100 to $200
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" value="200" type="radio" name="pricefilter" id="200above" wire:model="filters.price">
                            <label class="form-check-label ps-2" for="200above">
                                $200 and Above
                            </label>
                        </div>
                    </div>
                    <!-- card-body.// -->
                </div>
                <!-- collapse.// -->
            </article> --}}
    
            
            <article class="filter-group">
                <header class="card-header d-flex justify-content-between">
                    <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside_brands">
                        Brands
                        <i class="fa fa-chevron-down float-right ms-1" aria-hidden="true"></i>
                    </a>
                                            </header>
                <div class="collapse show" id="collapse_aside_brands">
                    <div class="card-body">
                        @foreach ($brands as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="brand[]" value="{{$brand->id}}" id="{{$brand->id}}" wire:model="filters.brand">
                                <label class="form-check-label" for="{{$brand->id}}">
                                    {{$brand->name}}
                                </label>
                            </div>
                        @endforeach
                           
                    </div> 
                    <!-- card-body .// -->
                </div>
                <!-- collapse.// -->
            </article>

            <article class="filter-group">
                <header class="card-header d-flex justify-content-between">
                    <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside_vendors">
                        Vendors
                        <i class="fa fa-chevron-down float-right ms-1" aria-hidden="true"></i>
                    </a>
                                            </header>
                <div class="collapse show" id="collapse_aside_vendors">
                    <div class="card-body">
                        @foreach ($vendors as $vendor)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="vendor[]" value="{{$vendor->id}}" id="{{$vendor->id}}" wire:model="filters.vendor">
                                <label class="form-check-label" for="{{$vendor->id}}">
                                    {{$vendor->first_name}} {{$vendor->last_name}}
                                </label>
                            </div>
                        @endforeach
                               
                    </div>
                    <!-- card-body .// -->
                </div>
                <!-- collapse.// -->
            </article>

            <article class="filter-group">
                <header class="card-header d-flex justify-content-between">
                    <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside_inventories">
                        Inventories
                        <i class="fa fa-chevron-down float-right ms-1" aria-hidden="true"></i>
                    </a>
                                            </header>
                <div class="collapse show" id="collapse_aside_inventories">
                    <div class="card-body">
                        @foreach ($inventories as $inventory)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="inventory[]" value="{{$inventory->id}}" id="{{$inventory->id}}" wire:model="filters.inventory">
                                <label class="form-check-label" for="{{$inventory->id}}">
                                    {{$inventory->name}}
                                </label>
                            </div>
                        @endforeach
                               
                    </div>
                    <!-- card-body .// -->
                </div>
                <!-- collapse.// -->
            </article>

            <article class="filter-group">
                <header class="card-header d-flex justify-content-between">
                    <a href="#" class="title" data-bs-toggle="collapse" data-bs-target="#collapse_aside1">
                        Item Quantity
                        <i class="fa fa-chevron-down float-right ms-1" aria-hidden="true"></i>
                    </a>
                                            </header>
                <div class="collapse show" id="collapse_aside1">
                    <div class="card-body">
                    
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="qty" value="qty" id="qty" wire:model="filters.qty">
                                <label class="form-check-label" for="qty">
                                    Exceeds 50 
                                </label>
                            </div>
                         
                    </div>
                    <!-- card-body .// -->
                </div>
                <!-- collapse.// -->
            </article>


            <button type="submit" class="btn btn-warning mb-3 w-100 " >
                Filter
            </button>
        </div>
        <!-- card.// -->
        <!-- ===== Card for sidebar filter .// ===== -->
        
    </form>
    </aside>
    <!-- ====== Sidebar Ends Here =======-->
    {{-- items --}}
        <div class="container products col-lg-9">
            <div class="row">
                @foreach($items as $item)
                @if($item->available==1)
                    <div class="col-xs-18 col-sm-6 col-md-3" style="margin-left:30px">
                        <div class="thumbnail">
                            <img style="height:150px;width:200px;"
                            src="{{$item->image ? asset('images/'.$item->image) : asset('/images/Caption-for-Profile.jpg')}}" width="500" height="300">
                            <div class="caption" style="text-align:center">
                                <h4 style="margin-left:30px;">{{ $item->name }}</h4>
                                <p><strong>Price: </strong> {{ $item->price }}$</p>
                                <p class="btn-holder" ><a href="{{ url('add-to-cart/'.$item->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    
</div>
</section>
@endsection

         
