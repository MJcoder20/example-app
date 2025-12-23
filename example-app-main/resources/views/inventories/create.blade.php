@extends('layouts.app')

@section('content')
    <div class="container">
    <h1 style="font-size:40px;font-weight:bold">Create Inventory</h1>
    <div class="py-5 text-center" style="font-size:20px;">
        <form action="/inventories" method="post" enctype="multipart/form-data">
            @csrf
           

            <div class="row">
                <label for="name"  class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input id="name" type="text" name="name" required
                    class="@error('name') is_invalid @enderror form-control"/>
                </div>
                @error('name')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>
            
            
            <div class="row ">
                <label for="city_id" class="col-sm-3 col-form-label">City Id</label>
                <div class="col-sm-9">
                <input id="city_id" type="text" name="city_id" 
                class="@error('city_id') is_invalid @enderror form-control"/>
                </div>
                @error('city_id')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>


            <div class="row">
                <label for="phone" class="col-sm-3 col-form-label">Phone Number</label>
                <div class="col-sm-9">
                    <input id="phone" type="text" name="phone" required
                    class="@error('phone') is_invalid @enderror form-control"/>
                </div>
                @error('phone')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>


            <div class="row">
                <label for="is_active" class="col-sm-3 col-form-label">Enter 0 for inactive or 1 for active</label>
                <div class="col-sm-9">
                  <input id="is_active" type="text" name="is_active" 
                  class="@error('is_active') is_invalid @enderror form-control"/>
                </div>
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">{{ __('Create Inventory') }}</button>            
        </form>
        </div>
    </div>
@endsection