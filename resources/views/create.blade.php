<x-layout>
    
        <form action="/" method="post" >
            @csrf
           
            <div class="form-group">
                <label for="username" >UserName</label>
               
                    <input id="username" type="text" name="username" required
                    class="@error('username') is_invalid @enderror form-control"/>
            
                @error('username')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email" >User email</label>
            
                    <input id="email" type="text" name="email" required
                    class="@error('email') is_invalid @enderror form-control"/>
          
                @error('email')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group ">
                <label for="first_name">First Name</label>
               
                <input id="first_name" type="text" name="first_name"
                class="@error('first_name') is_invalid @enderror form-control"/>
            
                @error('first_name')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="last_name" >Last Name</label>
              
                <input id="last_name" type="text" name="last_name" 
                class="@error('last_name') is_invalid @enderror form-control"/>
            
                @error('last_name')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="is_admin">Enter 0 for user or 1 for admin</label>
           
                    <input id="is_admin" type="text" name="is_admin" 
                    class="@error('is_admin') is_invalid @enderror form-control"/>
             
                @error('is_admin')
                    <div  class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="is_active">Enter 0 for inactive or 1 for active</label>
                
                  <input id="is_active" type="text" name="is_active" 
                  class="@error('is_active') is_invalid @enderror form-control"/>
                
                @error('is_active')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="password" >Password</label>
                
                    <input id="password" type="password" name="password" required
                    class="@error('password') is_invalid @enderror form-control"/>
               
                @error('password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="form-group ">
                <label for="confirm_password" >Confirm Password</label>
              
                    <input id="confirm_password" type="password" name="confirm_password" required
                    class="@error('confirm_password') is_invalid @enderror form-control"/>
            
                @error('confirm_password')
                    <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mb-2">Create User</button>            
        </form>
   
</x-layout>