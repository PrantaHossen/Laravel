@extends('Front.layouts.app')

@section('content')
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('shop.index') }}">Shop</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="{{ route('account.checkoutProcess') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        @include('Admin.AppMessage')
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" value="{{ old('first_name', $customerAddress->first_name ?? '') }}" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                                placeholder="First Name">
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                                placeholder="Last Name" value="{{ old('last_name', $customerAddress->last_name ?? '') }}">
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email" value="{{ old('email', $customerAddress->email ?? '') }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control @error('country') is-invalid @enderror">
                                                <option value="">Select a Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{ old('country', $customerAddress->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control @error('address') is-invalid @enderror">{{ old('address', $customerAddress->address ?? '') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="apartment" id="apartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('apartment', $customerAddress->apartment ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                                                placeholder="City" value="{{ old('city', $customerAddress->city ?? '') }}">
                                            @error('city')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror"
                                                placeholder="State" value="{{ old('state', $customerAddress->state ?? '') }}">
                                            @error('state')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control @error('zip') is-invalid @enderror"
                                                placeholder="Zip" value="{{ old('zip', $customerAddress->zip ?? '') }}">
                                            @error('zip')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                                                placeholder="Mobile No." value="{{ old('mobile', $customerAddress->mobile ?? '') }}">
                                            @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                class="form-control">{{ old('order_notes') }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summary</h2>
                        </div>
                        <div class="card cart-summary">
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6">{{ $item->name }} X {{ $item->qty }}</div>
                                        <div class="h6">${{ number_format($item->price * $item->qty, 2) }}</div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-between summary-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>${{ Cart::subtotal() }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>$0</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summary-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong>${{ Cart::total() }}</strong></div>
                                </div>
                            </div>
                        </div>

                        <div class="card payment-form">
                            <div class="card-title h5 mb-3">Payment Method</div>
                            <div class="card-body p-0">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" checked name="payment_method" value="cod"
                                        id="payment_method_cod">
                                    <label for="payment_method_cod" class="form-check-label">COD</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="payment_method" value="stripe" id="payment_method_stripe">
                                    <label for="payment_method_stripe" class="form-check-label">Stripe</label>
                                </div>
                            </div>

                            <div class="card-body p-0 d-none mt-3" id="card-payment-form">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number"
                                        placeholder="Valid Card Number" class="form-control @error('card_number') is-invalid @enderror">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY"
                                            class="form-control @error('expiry_date') is-invalid @enderror">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cvv" class="mb-2">CVV Code</label>
                                        <input type="text" name="cvv" id="cvv" placeholder="123"
                                            class="form-control @error('cvv') is-invalid @enderror">
                                        @error('cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn btn-dark btn-block w-100">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            $('input[name="payment_method"]').on('change', function() {
                if ($(this).val() === 'stripe') {
                    $('#card-payment-form').removeClass('d-none');
                } else {
                    $('#card-payment-form').addClass('d-none');
                }
            });
        });
    </script>
@endsection
