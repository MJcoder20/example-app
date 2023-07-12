<x-layout>
    
        <form action="/" method="post">
            @csrf
            <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">UserName</label>
                <div class="col-sm-10">
                    <input id="username" type="text" name="username" 
                    class="@error('username') is_invalid @enderror form-control"/>
                </div>
                @error('username')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">User email</label>
                <div class="col-sm-10">
                    <input id="email" type="text" name="email"
                    class="@error('email') is_invalid @enderror form-control"/>
                </div>
                @error('email')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <input id="first_name" type="text" name="first_name"
                    class="@error('first_name') is_invalid @enderror form-control"/>
                </div>
                @error('first_name')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <input id="last_name" type="text" name="last_name" 
                    class="@error('last_name') is_invalid @enderror form-control"/>
                </div>
                @error('last_name')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="is_admin" class="col-sm-2 col-form-label">Enter 0 for user or 1 for admin</label>
                <div class="col-sm-10">
                    <input id="is_admin" type="text" name="is_admin" 
                    class="@error('is_admin') is_invalid @enderror form-control"/>
                </div>
                @error('is_admin')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="is_active" class="col-sm-2 col-form-label">Enter 0 for inactive or 1 for active</label>
                <div class="col-sm-10">
                  <input id="is_active" type="text" name="is_active" 
                  class="@error('is_active') is_invalid @enderror form-control"/>
                </div>
                @error('is_active')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input id="password" type="password" name="password" 
                    class="@error('password') is_invalid @enderror form-control"/>
                </div>
                @error('password')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input id="confirm_password" type="password" name="confirm_password" 
                    class="@error('confirm_password') is_invalid @enderror form-control"/><br><br>
                </div>
                @error('confirm_password')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>            
        </form>
   
</x-layout>