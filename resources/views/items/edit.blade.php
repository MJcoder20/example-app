@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 style="font-size:40px;font-weight:bold">Update Item</h1>
        <div class="py-5 text-center" style="font-size:20px;">
        <form action="/items/{{$item->id}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                <input id="name" type="text" name="name" required value="{{$item->name}}"
                class="@error('name') is_invalid @enderror form-control"/>
                </div>
                @error('name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>


            <div class="row">
                <label for="imageName"  class="col-sm-3 col-form-label">Current Image</label>
                <div class="col-sm-9">          
                <br><br><img style="height:150px;width:200px; transform: translate(-50%, -20%);"
                src="{{$item->image ? asset('images/'.$item->image) : asset('/images/Caption-for-Profile.jpg')}}"/><br>
                <input id="imageName" type="text" name="imageName" value="{{$item->image}}" 
                class="form-control"/>
               
                </div>
            </div>
            <div class="row">
                <label for="image"  class="col-sm-3 col-form-label">New Image</label>
                <div class="col-sm-9">
                <input id="image" type="file" name="image" value="images/{{$item->image}}"
                class="@error('image') is_invalid @enderror form-control"/>
                </div>
                @error('image')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>


            <div class="row">
                <label for="brand_id" class="col-sm-3 col-form-label">Brand Id</label>
                <div class="col-sm-9">
                <input id="brand_id" type="text" name="brand_id" 
                value="{{$item->brand_id}}" 
                class="@error('brand_id') is_invalid @enderror form-control"/>
                </div>
                @error('brand_id')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row">
                <label for="is_active" class="col-sm-3 col-form-label">Enter 0 for inactive or 1 for active</label>
                <div class="col-sm-9">
                <input id="is_active" type="text" name="is_active" 
                value="{{$item->is_active}}" 
                class="@error('is_active') is_invalid @enderror form-control"/>
                </div>
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>


           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">{{ __('Update Item') }}</button>
            
        </form>  
    </div>
</div>
@endsection