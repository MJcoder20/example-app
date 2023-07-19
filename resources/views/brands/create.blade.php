@extends('layouts.app')

@section('content')
    <div class="container">
    <h1 style="font-size:40px;font-weight:bold">Create Brand</h1>
    <div class="py-5 text-center" style="font-size:20px;">
        <form action="/brands" method="post" >
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
            
            <div class="row">
                <label for="icon"  class="col-sm-3 col-form-label">Brand Icon</label>
                <div class="col-sm-9">
                <input id="icon" type="image" name="icon"
                class="@error('icon') is_invalid @enderror form-control"/>
                </div>
                @error('icon')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

            <div class="row ">
                <label for="notes" class="col-sm-3 col-form-label">Notes</label>
                <div class="col-sm-9">
                <input id="notes" type="textarea" name="notes" 
                class="@error('notes') is_invalid @enderror form-control"/>
                </div>
                @error('notes')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div><br>

           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">{{ __('Create Brand') }}</button>            
        </form>
        </div>
    </div>
@endsection