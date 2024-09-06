@extends('Front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white ">
        <div class="container">
            @include('Admin.AppMessage')
            <div class="light-font center">
                <h2>Thank You for Your Order!</h2>
                <p>Your order ID is: <strong>{{ $orderId }}</strong></p>
                <p>We will process your order and notify you once it is ready for shipment.</p>
            </div>
        </div>
    </section>
@endsection
