@extends('layouts.app')

@section('content')
   
<div class="container">
    <div class="py-5 text-center">
    @if(Auth::user()->is_admin==1)
    <h1 style="font-size:40px;font-weight:bold">Users List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($users as $user)
        <div class="p-2" >
        <li class="list-group-item " >
            <div class="d-flex flex-row justify-content-start" style="font-size:20px;padding-top:25px;text-align: center;">
                {{$user->username}}   -   {{ $user->first_name }} {{ $user->last_name }}   -   {{ $user->email }}
            @if($user->is_active==1)
            -   Active
         
            @else
            -   Inactive
            @endif
            @if($user->is_admin==1)
            -   Admin
         
            @else
            -   User
            @endif
        </div>
        <div class="d-flex  justify-content-end">
            <br><a class="btn btn-outline-info" style="margin-right:20px;" href="/users/{{$user->id}}/edit">Edit</a>     
            <form action="/users/{{$user->id}}" method="post">
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
    {{-- {{ $users->links() }} --}}
    @else
    <h1>You're not an admin</h1>
</div>
</div>
    @endif
    
@endsection