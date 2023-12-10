@extends('layouts.app')

@section('content')
    <div class="s-cont">
        <img class="logo" src="{{ asset('/images/Popcorn_logo.png') }}">
        <div class="container">
            <div class="mb-3 row align-items-end" id="login-message"></div>
            <div class="link">
                <h4><a class="login" href="#">Login</a></h4>
                <h4><a class="signup" href="{{ route('register') }}">Sign Up</a></h4>
                <!-- Replace 'signup' with your actual route name -->
            </div>
            <div class="form-container">
                <form id="login-form" method="post">
                    @csrf <!-- Blade syntax for CSRF token -->

                    <label for="email">Email</label><br />
                    <div>
                        <input type="text" id="email" name="email" placeholder="e.g. your_email@gmail.com"
                            autocomplete="email">
                    </div>
                    <br />
                    <label for="password">Password</label><br />
                    <div>
                        <input type="password" id="password" name="password" autocomplete="current-password">
                    </div>
                    <input type="submit" class="btn" value="Login">
                </form>
            </div>

            <h2>Sign in using:</h2>
            <div class="sign-with">
                <h3>
                    <a id="google"><i class="fa-brands fa-google fa-fade fa-2xl"></i></a>
                    <a id="facebook"><i class="fa-brands fa-facebook fa-fade fa-2xl"></i></a>
                </h3>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //google sign in
            $(document).ready(function() {
                $('#google').click(function() {
                    // Google's OAuth 2.0 endpoint for requesting an access token
                    var oauth2Endpoint = 'https://accounts.google.com/o/oauth2/v2/auth';

                    // Parameters to pass to OAuth 2.0 endpoint.
                    var params = {
                        'client_id': '120437468224-ee1frt59u3meub3n6q2p4asrsqqm6pt4.apps.googleusercontent.com',
                        'redirect_uri': 'http://localhost:3000/index.php',
                        'response_type': 'token',
                        'scope': 'https://www.googleapis.com/auth/drive.metadata.readonly',
                        'include_granted_scopes': 'true',
                        'state': 'pass-through value'
                    };

                    // Create a form element and append it to the body.
                    var form = $('<form>', {
                        'method': 'GET',
                        'action': oauth2Endpoint
                    });

                    // Add form parameters as hidden input values.
                    for (var p in params) {
                        $('<input>', {
                            'type': 'hidden',
                            'name': p,
                            'value': params[p]
                        }).appendTo(form);
                    }

                    // Add form to page and submit it to open the OAuth 2.0 endpoint.
                    form.appendTo('body').submit();
                });
            });

            //facebook sign in
            $(document).ready(function() {
                $('#facebook').click(function() {
                    var oauth2Endpoint = 'https://www.facebook.com/v18.0/dialog/oauth?'

                    var params = {
                        'app_id': '2085385335132848',
                        'response_type': 'token',
                        'redirect_uri': 'http://localhost:3000/index.php',
                    };

                    // Create a form element and append it to the body.
                    var form = $('<form>', {
                        'method': 'GET',
                        'action': oauth2Endpoint
                    });

                    // Add form parameters as hidden input values.
                    for (var p in params) {
                        $('<input>', {
                            'type': 'hidden',
                            'name': p,
                            'value': params[p]
                        }).appendTo(form);
                    }

                    // Add form to page and submit it to open the OAuth 2.0 endpoint.
                    form.appendTo('body').submit();
                });
            });
            //normal log in
            $('#login-form').submit(function(e) {
                e.preventDefault();

                var email = $('#email').val();
                var password = $('#password').val();

                // Include CSRF token in data
                var data = {
                    email: email,
                    password: password,
                    _token: $('meta[name="csrf-token"]').attr('content') // Add this line
                };

                // Make the AJAX request
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.index') }}",
                    data: data,
                    success: function(data) {
                        $('#login-message').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log any error message in the console
                    }
                });
            });
        });
    </script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection
