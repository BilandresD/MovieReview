<!DOCTYPE html>
<html>

<head>
    <title>Sign Up | PopCorn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/9dd1cea6a6.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('./css/login.css')}}">
    <script src="signup.js"></script>
</head>

<body>
    <div class="s-cont">
        <img class="logo" src="{{asset('/images/Popcorn_logo.png')}}">
        <div class="container">
            <div class="link">
                <h4><a class="login" href="login.php">Login</a></h4>
                <h4><a class="signup" href="#">Sign Up</a></h4>
            </div>
            <div class="form-container">
                <form id="signupform" method="post">
                    <label for="email">Email</label><br/>
                    <div>
                        <input type="text" id="email" name="email" placeholder="e.g. your_email@gmail.com"
                            autocomplete="email">
                    </div>
                    <br/>
                    <label for="password">Password</label><br/>
                    <div>
                        <input type="password" id="password" name="password"
                            autocomplete="current-password">
                    </div>
                    <input type="submit" class="btn" value="Sign Up">
                </form>
            </div>
        </div>
    </div>

    <div id="message"></div>

</body>

</html>