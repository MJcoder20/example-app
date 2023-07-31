@extends('layouts.layout')
@section('title', 'Cart')
@section('content')
    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th style="width:50%">Item</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                <?php $total += $details['price'] * $details['quantity'] ?>
                <tr>
                    <td data-th="Item">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] ? asset('images/'.$details['image']) : asset('/images/Caption-for-Profile.jpg') }}" width="100" height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">${{ $details['price'] }}</td>
                    <td data-th="Quantity">
                        <form action="update-cart/{{$id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="form-control quantity" />
                    </td>
                    <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                    <td class="actions" data-th="">
                        
                            <button type="submit" class="btn btn-info btn-sm update-cart"><i class="fa fa-refresh"></i></button>
                            {{-- <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button> --}}
                        </form>
                        <form action="remove-from-cart/{{$id}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm remove-from-cart"><i class="fa fa-trash-o"></i></button>
                            {{-- <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button> --}}
                        </form>
                        
                    </td>
                </tr>
            @endforeach

        @endif
        </tbody>
        <tfoot>
        <tr class="visible-xs">
            <td class="text-center"><strong>Total {{ $total }}</strong></td>
        </tr>
        <tr>
            <td><a href="{{ url('/Items') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total ${{ $total }}</strong></td>
            <td>
                <form action="/cart/purchase" method="get">
                    @csrf
                    <button type="submit" class="btn btn-warning">Complete Purchase</button>
                </form>
            </td>
            </tr>
        </tfoot>
    </table>
@endsection
@section('scripts')
    {{-- <script type="text/javascript">
        $(".update-cart").click(function (e) {
           e.preventDefault();
           var ele = $(this);
            $.ajax({
               url: '{{ url('update-cart') }}',
               method: "patch",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script> --}}
@endsection