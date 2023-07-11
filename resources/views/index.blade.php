<x-layout>
    <nav aria-label="Page navigation example">
        <h1>Users List</h1>
        <ul class="pagination">
        @foreach($users as $user)
        <span><li class="page-item">{{$user->username}}  -  {{ $user->email }}
            @if($user->is_active==1)
            -  {{ $user->email }}
            @endif
            <br><a href="/users/{{$user->id}}/edit">Edit</a> 
            <form action="/users/{{$user->id}}" method="post">
                @csrf
                @method('DELETE')
                <button>Delete</button>
            </form>
       
        </li></span>
        @endforeach
        </ul>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</x-layout>