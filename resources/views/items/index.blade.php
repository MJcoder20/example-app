@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">

    <h1 style="font-size:40px;font-weight:bold">Items List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($items as $item)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                @if($item->image)
                <img src="/public/images/{{$item->image}}" style="height: 80px;width:100px;margin-right:20px">    
                @else 
                <span>No image found!</span>
                @endif    -   {{$item->name}}   -   {{ $item->brand_id }}   -     
                @if($item->is_active==1)
                -   Active
             
                @else
                -   Inactive
                @endif
        
        </div>
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/items/{{$item->id}}/edit">Edit</a>     
            <form action="/items/{{$item->id}}" method="post">
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
  
</div>
</div>

@endsection