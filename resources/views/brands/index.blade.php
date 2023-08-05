@extends('layouts.app')

@section('content')
<div class="row">
    <aside class="col-lg-3">
        
    
        <!-- ===== Card for sidebar filter ===== -->
        <div id="aside_filter" class="collapse card d-lg-block mb-5">
            <form action="">
           
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
<div class="container">
    <div class="py-5 text-center">

    <h1 style="font-size:40px;font-weight:bold">Brands List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($brands as $brand)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                {{-- <img style="height: 80px;width:100px;"
                src="{{$brand->icon ? asset('images/'.$brand->icon) : asset('/images/Caption-for-Profile.jpg')}}"/> --}}
                
                   {{ $brand->name }}   
                   {{-- -   {{ $brand->notes }}   --}}
           
        
        </div>
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-success" style="margin-right:20px;" href="/brands/{{$brand->id}}">Show</a>     
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/brands/{{$brand->id}}/edit">Edit</a>     
            <form action="/brands/{{$brand->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger ">{{ __('Delete') }}</button>
            </form>
        </div>
      
        </li>
        </div>
        
        @endforeach
        </ul>
    </div>
    {{$brands->links()}}
</div>
</div>
</div>
@endsection