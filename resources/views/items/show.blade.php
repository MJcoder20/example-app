@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">
        <div class="d-flex flex-column"><br><br><br>
            <h1 style="text-align:center;font-size:50px;font-weight:bold">{{$item->name}}</h1>
            <br><br>
            <img style="height:150px;width:200px; transform: translate(220%, -20%);"
            src="{{$item->image ? asset('images/'.$item->image) : asset('/images/Caption-for-Profile.jpg')}}"/><br><br><br>
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                This item belongs to brand with id: {{ $item->brand_id }}
            </h3>
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                This item is 
                @if($item->is_active==1)
                   Active
             
                @else
                   Inactive
                @endif
            </h3>
        </div>
  
</div>
</div>

@endsection