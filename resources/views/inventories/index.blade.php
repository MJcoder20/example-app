@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">

    <h1 style="font-size:40px;font-weight:bold">Inventory List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($inventories as $inventory)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                   {{$inventory->name}}   
        
        </div>
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-success" style="margin-right:20px;" href="/inventories/{{$inventory->id}}">Show</a>     
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/inventories/{{$inventory->id}}/edit">Edit</a>     
            <form action="/inventories/{{$inventory->id}}" method="post">
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
    {{$inventories->links()}}
</div>
</div>

@endsection