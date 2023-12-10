<!-- eto yung nasa admin na rating where you can delete the ratings of movies -->

<!DOCTYPE html>
<html>

<head>
    <title>Ratings</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('./css/reviewdelete.css')}}">
    <script src="admin.js"></script>
</head>

<body>
    <nav class="navbar">
        <img class="logo" src="{{asset('images/Popcorn_logo.png')}}">
        <div class="link-cont">
            <div class="link">
                <a href="admin.php">Users</a>
            </div>
            <div class="link">
                <a href="dashboard.php">Log Out</a>
            </div>
        </div>
    </nav>

    <input type="text" id="searchInput" placeholder="Search movies...">
    
    <div id="ratingsTable">
        <table class="rating-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Movie Title</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="ratingsBody"></tbody>
        </table>
    </div>

    <script>
        $('#searchInput').on('input', function () {
            var searchValue = $(this).val().toLowerCase();
            $('#ratingsBody tr').each(function () {
                var title = $(this).find('td:nth-child(2)').text().toLowerCase();
                var rating = $(this).find('td:nth-child(3)').text().toLowerCase();
                var review = $(this).find('td:nth-child(4)').text().toLowerCase();

                if (title.includes(searchValue) || rating.includes(searchValue) || review.includes(searchValue)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    </script>
</body>

</html>