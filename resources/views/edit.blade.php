<x-layout>
    <div class="container">
        <h1 style="font-size:40px;font-weight:bold">Update User</h1>
        <div class="py-5 text-center">
        <form action="/users/{{$user->id}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="username">UserName</label>
                <input id="username" type="text" name="username" required value="{{$user->username}}"
                class="@error('username') is_invalid @enderror form-control"/><br><br>
                @error('username')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">User email</label>
                <input id="email" type="text" name="email" required value="{{$user->email}}"
                class="@error('email') is_invalid @enderror form-control"/><br><br>
                @error('email')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div  class="form-group">
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" name="first_name"
                 value="{{$user->first_name}}" 
                 class="@error('first_name') is_invalid @enderror form-control"/><br><br>
                @error('first_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div  class="form-group">
                <label for="last_name">Last Name</label>
                <input id="last_name" type="text" name="last_name" 
                value="{{$user->last_name}}" 
                class="@error('last_name') is_invalid @enderror form-control"/><br><br>
                @error('last_name')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div  class="form-group">
                <label for="is_admin">Enter 0 for user or 1 for admin</label>
                <input id="is_admin" type="text" name="is_admin" 
                value="{{$user->is_admin}}" 
                class="@error('is_admin') is_invalid @enderror form-control"/><br><br>
                @error('is_admin')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div  class="form-group">
                <label for="is_active">Enter 0 for inactive or 1 for active</label>
                <input id="is_active" type="text" name="is_active" 
                value="{{$user->is_active}}" 
                class="@error('is_active') is_invalid @enderror form-control"/><br><br>
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" 
                value="{{$user->password}}" 
                class="@error('password') is_invalid @enderror form-control"/><br><br>
                @error('password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input id="confirm_password" type="password" name="confirm_password"  
                class="@error('confirm_password') is_invalid @enderror form-control"/><br><br>
                @error('confirm_password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
           
            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">Update User</button>
            
        </form>  
    </div>
</div>
</x-layout>