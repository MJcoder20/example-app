@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="font-size:40px;font-weight:bold">Update User</h1>
        <div class="py-5 text-center">
        <form action="/users/{{$user->id}}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <label for="username" class="col-sm-3 col-form-label">UserName</label>
                <div class="col-sm-9">
                <input id="username" type="text" name="username" required value="{{$user->username}}"
                class="@error('username') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('username')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                <input id="email" type="text" name="email" required value="{{$user->email}}"
                class="@error('email') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                <input id="first_name" type="text" name="first_name"
                 value="{{$user->first_name}}" 
                 class="@error('first_name') is_invalid @enderror form-control"/><br><br>
                </div>
                 @error('first_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                <input id="last_name" type="text" name="last_name" 
                value="{{$user->last_name}}" 
                class="@error('last_name') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('last_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="is_admin" class="col-sm-3 col-form-label">Enter 0 for user or 1 for admin</label>
                <div class="col-sm-9">
                <input id="is_admin" type="text" name="is_admin" 
                value="{{$user->is_admin}}" 
                class="@error('is_admin') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('is_admin')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="is_active" class="col-sm-3 col-form-label">Enter 0 for inactive or 1 for active</label>
                <div class="col-sm-9">
                <input id="is_active" type="text" name="is_active" 
                value="{{$user->is_active}}" 
                class="@error('is_active') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="password" class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                <input id="password" type="password" name="password" 
                value="{{$user->password}}" 
                class="@error('password') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                <div class="col-sm-9">
                <input id="confirm_password" type="password" name="confirm_password" 
                value="{{$user->password}}" 
                class="@error('confirm_password') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('confirm_password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>
           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">{{ __('Update User') }}</button>
            
        </form>  
    </div>
</div>
@endsection