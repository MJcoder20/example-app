@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">
        <div class="d-flex flex-column"><br><br><br>
            <h1 style="text-align:center;font-size:50px;font-weight:bold">{{$brand->name}}</h1>
            <br><br>
            <img style="height:150px;width:200px; transform: translate(220%, -20%);"
            src="{{$brand->icon ? asset('images/'.$brand->icon) : asset('/images/Caption-for-Profile.jpg')}}"/><br><br><br>
        
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                {{$brand->notes}}
            </h3>
        </div>
  
</div>
</div>

@endsection