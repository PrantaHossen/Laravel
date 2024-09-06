@extends('Front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('Front.index')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('shop.index')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                @if(Session::has('success'))
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoDismissAlert">
                            <strong>{{Session::get('success')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                @endif

                @if(Session::has('error'))
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="alert alert-warning  alert-dismissible fade show" role="alert" id="autoDismissAlert">
                            <strong>{{Session::get('error')}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
                @endif

                @if (Cart::count() > 0)
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>

                            <tbody>
                                    @foreach ($cartContent as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->image != '' && file_exists(public_path('uploads/products/' . $item->image))
                                                        ? asset('uploads/products/' . $item->image)
                                                        : asset('/demo-assets/productDemo.jpg') }}"
                                                        alt="" class="img-fluid"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <h2>{{ $item->name }}</h2>
                                                </div>
                                            </td>
                                            <td>
                                                $ {{ $item->price }}
                                            </td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">


                                                    <div class="input-group-btn">
                                                        <button name="sub" id="sub"
                                                            class="sub btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1" data-id="{{$item->rowId}}" >
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm border-0 text-center"
                                                        value="{{ $item->qty }}">
                                                    <div class="input-group-btn">
                                                        <button name="add" id="add"
                                                            class="add btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1" data-id="{{$item->rowId}}" >
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                $ {{ $item->qty * $item->price }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="deleteItem('{{$item->rowId}}');">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h2>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{ Cart::Subtotal() }}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                <div>$0</div>
                            </div>
                            <div class="d-flex justify-content-between summery-end">
                                <div>Total</div>
                                <div>${{ Cart::Subtotal() }}</div>
                            </div>
                            <div class="pt-5">
                                <a href="{{route('account.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                    <div class="input-group apply-coupan mt-4">
                        <label>
                            <input type="text" placeholder="Coupon Code" class="form-control">
                        </label>
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div>
                </div>

            </div>
            @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <h3 class="text-danger">Your Cart is Empty!!</h3>
                    </div>
                    <div class="card-body d-flex justify-content-center align-item-center">
                        <p>Please Add a product to continue shopping. Thank you for being with us. Good Day :-)</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            $('.add').click(function() {
                var qtyElement = $(this).closest('.quantity').find('input'); // Target the input field
                var qtyValue = parseInt(qtyElement.val());
                if (qtyValue < 10) {
                    qtyElement.val(qtyValue+1)

                    var rowId = $(this).data('id');
                    var newQty= qtyElement.val();
                    updateCart(rowId,newQty);
                }
            });

            $('.sub').click(function() {
                var qtyElement = $(this).closest('.quantity').find('input'); // Target the input field
                var qtyValue = parseInt(qtyElement.val());
                if (qtyValue > 1) {
                    qtyElement.val(qtyValue - 1);

                    var rowId = $(this).data('id');
                    var newQty= qtyElement.val();
                    updateCart(rowId,newQty);
                }
            });
        });

        function updateCart(rowId,qty){
            $.ajax({
                url:'{{route("cart.updateCart")}}',
                type:'post',
                data:{rowId:rowId,qty:qty},
                dataType:'json',
                success: function(response){
                    window.location.href= "{{route('cart.cart')}}";
                }
            })
        }

        function deleteItem(rowId){

        if(confirm("Are You sure to Delete"))
        {
            $.ajax({
                url:'{{route("cart.deleteItem.cart")}}',
                type:'post',
                data:{rowId:rowId},
                dataType:'json',
                success: function(response){
                    window.location.href= "{{route('cart.cart')}}";
                }
            });
        }
        }

        setTimeout(function() {
        var alertElement = document.getElementById('autoDismissAlert');
        if (alertElement) {
            var bsAlert = new bootstrap.Alert(alertElement);
            bsAlert.close();
        }
    }, 1000);

    </script>
@endsection
