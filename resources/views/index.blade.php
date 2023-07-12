<x-layout>
    <h1 style="font-size:40px;font-weight:bold">Users List</h1>
    <br><br>
    <div class="d-flex flex-column">     
        <ul class="list-group">
        @foreach($users as $user)
        <div class="p-2">
        <li class="list-group-item ">
            <div class="d-flex flex-row justify-content-start">{{$user->username}}   -   {{ $user->email }}
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
            <br><a class="btn btn-outline-info" href="/users/{{$user->id}}/edit">Edit</a> 
            <form action="/users/{{$user->id}}" method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger ">Delete</button>
            </form>
        </div>
      
        </li>
        </div>
        
        @endforeach
        </ul>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</x-layout>