@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">

    <h1 style="font-size:40px;font-weight:bold">Items List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
            <a href="{{ url('/Items') }}" class="btn btn-warning">Item Shopping</a>
        @foreach($items as $item)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                 
                   {{$item->name}}   
        
        </div>
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-success" style="margin-right:20px;" href="/items/{{$item->id}}">Show</a>  
            @if(Auth::user() && Auth::user()->is_admin==1)   
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/items/{{$item->id}}/edit">Edit</a>     
            <form action="/items/{{$item->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger ">{{ __('Delete') }}</button>
            </form>
            @endif
        </div>
      
        </li>
        </div>
        
        @endforeach
        </ul>
    </div>
    {{-- {{$items->links()}} --}}
</div>
</div>

@endsection