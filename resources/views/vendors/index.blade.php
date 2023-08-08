@extends('layouts.app')

@section('content')

<div class="container">
    <div class="py-5 text-center">

    <h1 style="font-size:40px;font-weight:bold">Vendors List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($vendors as $vendor)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                {{$vendor->email}}   -   {{ $vendor->first_name }} {{ $vendor->last_name }}   -   ({{ $vendor->phone }})  
            @if($vendor->is_active==1)
            -   Active
         
            @else
            -   Inactive
            @endif
        
        </div>
        @if(Auth::user()->is_admin==1)
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/vendors/{{$vendor->id}}/edit">Edit</a>     
            <form action="/vendors/{{$vendor->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger ">{{ __('Delete') }}</button>
            </form>
        </div>
        @endif
        
      
        </li>
        </div>
        
        @endforeach
        </ul>
    </div>
    {{$vendors->links()}}
</div>
</div>

@endsection