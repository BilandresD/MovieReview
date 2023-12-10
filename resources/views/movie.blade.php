<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin | Manage Movies | PopCorn</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('./css/movie.css')}}">
</head>

<body>
    <nav class="navbar">
        <img class="logo" src="{{asset('/images/Popcorn_logo.png')}}">
        <div class="link-cont">
            <div class="link">
                <a href="admin.php">Users</a>
            </div>
            <div class="link">
                <a href="reviewdelete.php">Reviews</a>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <form id="MovieForm" enctype="multipart/form-data">
            <label for="title">Title</label><br />
            <input type="text" id="title" name="title">

            <label for="overview">Overview</label><br />
            <textarea id="overview" name="overview"></textarea><br />

            <div class="cont2">
                <div>
                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" name="release_date"><br />
                </div>
                <div>
                    <label for="image">Choose Image</label>
                    <input type="file" name="image" accept="image/*"><br />
                </div>
            </div>
            <input type="submit" value="Add Movie">
        </form>
    </div>

    <div id="movieTable">
        <table class="movie-table">
            <thead>
                <tr>
                    <th>Movie Title</th>
                    <th>Genre</th>
                    <th>Year Release</th>
                    <th>Poster</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="movieBody"></tbody>
        </table>
    </div>
    <input type="hidden" name="addMovie" value="true">
</body>
<script>
    //loadmovies
    $(document).ready(function () {
        loadMovies();
    });

    function loadMovies() {
        $.ajax({
            url: "moviefunction.php",
            method: "POST",
            data: {
                "getMovie": true,
            },
            dataType: "json",
            success: function (data) {
                var tBody = "";
                var cnt = 1;

                if (data.length > 0) {
                    data.forEach(function (movie) {
                        tBody += `<tr>`;
                        tBody += `<td>` + movie['title'] + `.</td>`;
                        tBody += `<td>` + movie['overview'] + `.</td>`;
                        tBody += `<td>` + movie['release_date'] + `.</td>`;
                        tBody += `<td><img src="${movie['image_path']}" style="max-width: 100px; max-height: 100px;" /></td>`;
                        tBody += `<td>
                            <button onclick="deleteMovie(${movie['id']})">Delete</button>
                        </td>`;
                        tBody += `</tr>`;
                    });
                } else {
                    tBody = `<tr><td colspan="5">No movies found</td></tr>`;
                }

                $('#movieBody').html(tBody);
            },
            error: function (error) {
                console.log(error);
                alert("Oops, something went wrong!");
            }
        });
    }

    // Insert movie
    $(document).ready(function () {
        $('#MovieForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData($(this)[0]); // Get form data
            formData.append("addMovie", true);

            $.ajax({
                url: 'moviefunction.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Handle success response
                    console.log('Movie added successfully');
                    loadMovies(); // Reload movies after adding a new one
                    // You can add further actions here if needed
                },
                error: function (error) {
                    // Handle error response
                    console.log('Error adding movie:', error);
                    // Display an error message or take appropriate action
                }
            });
        });
    });

    //delete
    function deleteMovie(movieId) {
        $.ajax({
            url: 'moviefunction.php',
            method: 'POST',
            data: {
                action: 'deleteMovie',
                movie_id: movieId
            },
            success: function (response) {
                // Reload movies after successful deletion
                loadMovies();
                console.log(response); // Log the response from the server
            },
            error: function (error) {
                console.log('Error deleting movie:', error);
            }
        });
    }
</script>

</html>