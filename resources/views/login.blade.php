<!DOCTYPE html>
<html>

<head>
    <title>Login | PopCorn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/9dd1cea6a6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('./css/login.css')}}">
    <script src="login.js"></script>
</head>

<body>
    <div class="s-cont">
    <img class="logo" src="{{asset('/images/Popcorn_logo.png')}}">
        <div class="container">
            <div class="mb-3 row align-items-end" id="login-message"></div>
            <div class="link">
                <h4><a class="login" href="#">Login</a></h4>
                <h4><a class="signup" href="signup.php">Sign Up</a></h4>
            </div>
            <div class="form-container">
                <form id="login-form" method="post">
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

    </script>
</body>

</html>

