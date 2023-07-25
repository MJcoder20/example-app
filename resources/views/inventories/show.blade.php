@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">
        <div class="d-flex flex-column"><br><br><br>
            <h1 style="text-align:center;font-size:50px;font-weight:bold">{{$inventory->name}}</h1>
            <br><br>
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                This inventory belongs to city with id: {{ $inventory->city_id }}
            </h3>
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                Phone Number: {{ $inventory->phone }}
            </h3>
            <h3 style="text-align:center;font-size:20px;font-weight:bold">
                This inventory is 
                @if($inventory->is_active==1)
                   Active
             
                @else
                   Inactive
                @endif
            </h3>
        </div>
  
</div>
</div>

@endsection