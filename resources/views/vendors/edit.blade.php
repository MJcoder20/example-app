@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="font-size:40px;font-weight:bold">Update Vendor</h1>
        <div class="py-5 text-center" style="font-size:20px;">
        <form action="/vendors/{{$vendor->id}}" method="post">
            @csrf
            @method('PUT')

            <div class="row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                <input id="email" type="text" name="email" required value="{{$vendor->email}}"
                class="@error('email') is_invalid @enderror form-control"/>
                </div>
                @error('email')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="first_name" class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-9">
                <input id="first_name" type="text" name="first_name"
                 value="{{$vendor->first_name}}" 
                 class="@error('first_name') is_invalid @enderror form-control"/>
                </div>
                 @error('first_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="last_name" class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-9">
                <input id="last_name" type="text" name="last_name" 
                value="{{$vendor->last_name}}" 
                class="@error('last_name') is_invalid @enderror form-control"/>
                </div>
                @error('last_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="is_active" class="col-sm-3 col-form-label">Enter 0 for inactive or 1 for active</label>
                <div class="col-sm-9">
                <input id="is_active" type="text" name="is_active" 
                value="{{$vendor->is_active}}" 
                class="@error('is_active') is_invalid @enderror form-control"/>
                </div>
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-9">
                <input id="phone" type="text" name="phone" required value="{{$vendor->phone}}"
                class="@error('phone') is_invalid @enderror form-control"/>
                </div>
                @error('phone')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">{{ __('Update Vendor') }}</button>
            
        </form>  
    </div>
</div>
@endsection