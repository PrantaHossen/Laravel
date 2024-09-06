@extends('Front.layouts.app')

@section('content')
    <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                        <li class="breadcrumb-item">Register</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-10">
            <div class="container">
                <div class="login-form">
                    <form action="{{ route('account.registerUser') }}" method="post">
                        @csrf
                        @include('Admin.AppMessage')
                        <h4 class="modal-title">Register Now</h4>

                        <div class="form-group">
                            <input required type="text" class="@error('name') is-invalid @enderror form-control"
                                placeholder="Name" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group position-relative">
                            <input required type="email" class="@error('email') is-invalid @enderror form-control"
                                placeholder="Email" id="email" name="email" value="{{ old('email') }}">
                            <span id="email-check" class="position-absolute" style="right: 40px; top: 50%; transform: translateY(-50%); font-size: 1.5rem;"></span>
                            <p id="email-message" class="text-muted" style="margin-top: 5px; display: none;"></p>
                            @error('email')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input required type="number" class="@error('phone') is-invalid @enderror form-control"
                                placeholder="Phone" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input required type="password" class="@error('password') is-invalid @enderror form-control"
                                                                 placeholder="Password" id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input required type="password" class="@error('password_confirmation') is-invalid @enderror form-control"
                                placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_confirmation')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group small">
                            <a href="{{ route('account.forgetPassword') }}" class="forgot-link">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block btn-lg" value="Register">Register</button>
                    </form>
                    <div class="text-center small">Already have an account? <a href="{{ route('account.login') }}">Login
                            Now</a></div>
                </div>
            </div>
        </section>
@endsection

@section('customJs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#email').on('keyup', function() {
            let email = $(this).val();
            let emailCheck = $('#email-check');
            let emailMessage = $('#email-message');

            // Clear the message and symbol if the input is empty
            if (email === '') {
                emailCheck.html('');
                emailMessage.hide();
                return;
            }

            $.ajax({
                url: '{{ route("check.email") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.exists) {
                        emailCheck.html('<span class="text-danger">✖</span>');
                        emailMessage.text('This email is already taken. Please try another one.');
                        emailMessage.removeClass('text-success').addClass('text-danger').show();
                    } else {
                        emailCheck.html('<span class="text-success">✔</span>');
                        emailMessage.text('This email is available.');
                        emailMessage.removeClass('text-danger').addClass('text-success').show();
                    }
                }
            });
        });
    });
</script>

@endsection
