@extends('layouts.layout')
@section('title', 'Items')
@section('content')

    <div class="container products">
        <div class="row">
            @foreach($items as $item)
                <div class="col-xs-18 col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img style="height:150px;width:200px;margin-left:30px;"
                        src="{{$item->image ? asset('images/'.$item->image) : asset('/images/Caption-for-Profile.jpg')}}" width="500" height="300">
                        <div class="caption" >
                            <h4 style="margin-left:30px;">{{ $item->name }}</h4>
                            {{-- <p><strong>Price: </strong> {{ $product->price }}$</p> --}}
                            <p class="btn-holder"><a href="{{ url('add-to-cart/'.$item->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

         
