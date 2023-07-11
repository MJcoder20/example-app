<x-layout>
    <div>
        <form action="/" method="post">
            @csrf
            <div>
                <label for="username">UserName</label>
                <input id="username" type="text" name="username" class="@error('username') is_invalid @enderror"/><br><br>
                @error('username')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="email">User email</label>
                <input id="email" type="text" name="email" class="@error('email') is_invalid @enderror"/><br><br>
                @error('email')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" name="first_name" class="@error('first_name') is_invalid @enderror"/><br><br>
                @error('first_name')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="last_name">Last Name</label>
                <input id="last_name" type="text" name="last_name" class="@error('last_name') is_invalid @enderror"/><br><br>
                @error('last_name')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="is_admin">Enter 0 for user or 1 for admin</label>
                <input id="is_admin" type="text" name="is_admin" class="@error('is_admin') is_invalid @enderror"/><br><br>
                @error('is_admin')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="is_active">Enter 0 for inactive or 1 for active</label>
                <input id="is_active" type="text" name="is_active" class="@error('is_active') is_invalid @enderror"/><br><br>
                @error('is_active')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="@error('password') is_invalid @enderror"/><br><br>
                @error('password')
                    <div>{{$message}}</div>
                @enderror
            </div>
            <div>
                <label for="confirm_password">Confirm Password</label>
                <input id="confirm_password" type="password" name="confirm_password" class="@error('confirm_password') is_invalid @enderror"/><br><br>
                @error('confirm_password')
                    <div>{{$message}}</div>
                @enderror
            </div>
            
            <input type="submit" name="create" value="Create user">
            
        </form>
    </div>
</x-layout>