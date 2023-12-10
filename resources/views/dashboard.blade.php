<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | PopCorn</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">
    <script src="dashboard.js"></script>
</head>

<body>
    <nav class="navbar">
        <img class="logo" src="{{asset('/images/Popcorn_logo.png')}}">
        <div class="box">
            <form name="search">
                <input class="searchbar input" type="text" id="searchInput" >
            </form>
            <!-- icon -->
            <i class="fas fa-search">Search</i>
        </div>
        <a href="login.php"><button class="bn3">Login</button></a>
    </nav>

    <div class="movies" id="movies-container"></div>
    <div class="movies" id="movies-container2"></div>
</body>
<script>

    //search
    $("#searchInput").on("input", function () {
        var searchValue = $(this).val().toLowerCase();
        $(".movies-card").each(function () {
            var title = $(this).data("title").toLowerCase();
            if (title.includes(searchValue)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>

</html>