@extends('layouts.app')

@section('content')
   
<div class="container">
    {{-- <div class="row justify-content-center" id="checkbox-example-filters" data-mdb-items=".checkbox-example-item" data-mdb-auto-filter="true">
        <div class="col-md-6" data-mdb-filter="color">
          <span class="fa-lg mb-5">Filter: Color</span>

          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="red">
            <label class="form-check-label" for="inlineCheckbox1">Red</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="blue">
            <label class="form-check-label" for="inlineCheckbox2">Blue</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="black">
            <label class="form-check-label" for="inlineCheckbox3">Black</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="gray">
            <label class="form-check-label" for="inlineCheckbox4">Gray</label>
          </div>
        </div>

        <div class="col-md-6" data-mdb-filter="sale">
          <span class="fa-lg mb-5">Filter: Sale</span>

          <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox5" value="yes">
            <label class="form-check-label" for="inlineCheckbox5">Yes</label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox6" value="no">
            <label class="form-check-label" for="inlineCheckbox6">No</label>
          </div>
        </div>
      </div> --}}


      
    {{-- <section>
        <section id="filters" data-auto-filter="true">
            <h5>Filters</h5>
            <section class="mb-5" data-filter="condition">
                <h6 class="font-weight-bold mb-3">Condition</h6>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="new" id="condition-checkbox">
                    <label class="form-check-label text-uppercase small text-muted" for="condition-checkbox">
                      New
                    </label>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="used" id="condition-checkbox2">
                    <label class="form-check-label text-uppercase small text-muted" for="condition-checkbox2">
                      Used
                    </label>
                </div>


            </section>
            <section class="mb-4">
                <h6 class="font-weight-bold mb-3">Price</h6>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="price-radio">
                  <label class="form-check-label text-uppercase small text-muted" for="price-radio">
                    Under $25
                  </label>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="price-radio2">
                  <label class="form-check-label text-uppercase small text-muted" for="price-radio2">
                    $25 to $50
                  </label>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="price-radio3">
                  <label class="form-check-label text-uppercase small text-muted" for="price-radio3">
                    $50 to $100
                  </label>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="price-radio4">
                  <label class="form-check-label text-uppercase small text-muted" for="price-radio4">
                    $100 to $200
                  </label>
                </div>

                <div class="form-check mb-3">
                  <input class="form-check-input" type="radio" name="flexRadioDefault" id="price-radio5">
                  <label class="form-check-label text-uppercase small text-muted" for="price-radio5">
                    $200 &amp; above
                  </label>
                </div>
              </section>

        </section>
    </section> --}}
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