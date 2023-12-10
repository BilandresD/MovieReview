
<!DOCTYPE html>
<html lang="en">
<style>
    .reviewText {
        text-transform: capitalize;
    }
</style>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review App</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/dashboard.css">

</head>

<body>
    <nav class="navbar">
        <img class="logo" src="Popcorn_logo.png">
        <div class="box">
            <form name="search">
                <input class="searchbar input" type="text" id="searchInput">
            </form>
            <!-- icon -->
            <i class="fas fa-search">Search</i>
        </div>
        <!-- <a href="dashboard.php">LOG-OUT</a> -->
        <a href="{{ route('login') }}"><button class="bn3">Login</button></a>
    </nav>

    <div class="movies" id="movies-container"></div>
    <div class="movies" id="movies-container2"></div>
</body>
<script>
    $(document).ready(function() {
        // Fetch movies from the server using AJAX
        $.ajax({
            url: "{{ route('movies.get') }}",
            method: "GET",
            data: {
                action: "fetch_movies",
            },
            dataType: "json",
            success: function(response) {
                if (response && response.length > 0) {
                    var movies = response;
                    var container = $("#movies-container2");
                    container.empty();

                    movies.forEach(function(movie) {
                        var title = movie.title;
                        var overview = movie.overview;
                        var poster_path = movie.image_path;
                        var release_date = movie.release_date;

                        var movieDiv = $("<div>").addClass("movies-card");
                        var movieImage = $("<img>")
                            .attr("src", poster_path)
                            .addClass("movie-poster");
                        var movieTitle = $("<p>").addClass("title").text(title);
                        movieDiv.append(movieImage, movieTitle);

                        movieDiv.data("title", title);
                        movieDiv.data("overview", overview);
                        movieDiv.data("release_date", release_date);

                        container.append(movieDiv);

                        // Create modals with review and rating functionalities
                        createModal(title, overview, poster_path, release_date);
                    });
                } else {
                    $("#movies-container2").html("<p>No movies found.</p>");
                }

                // Call this function after adding all modals
                initializeModals();
            },
            error: function(error) {
                console.error("Error fetching movies:", error);
            },
        });

        // Function to create modals with review and rating functionalities
        function createModal(title, overview, poster_path, release_date) {
            var sanitizedTitle = title.replace(/[^a-zA-Z0-9]/g, "");
            var modalTemplate = `
            <div class="modal fade" id="${sanitizedTitle}-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                        </div>
                        <div class="modal-body">
                            <img src="${poster_path}" alt="${title} Poster" class="modal-poster" style="max-width: 100%; height: auto;">
                            <p>${overview}</p>
                            <p>Date Released: ${release_date}</p>
                            <select class="rating-input">
    <option value="1">1 star</option>
    <option value="2">2 stars</option>
    <option value="3">3 stars</option>
    <option value="4">4 stars</option>
    <option value="5">5 stars</option>
</select>
                            <button type="button" class="btn btn-primary submit-rating">Submit Rating</button>
                        </div>
                        <div class="modal-footer">
                            <div class="movie-reviews"></div>
                        </div>
                    </div>
                </div>
            </div>`;
            $("body").append(modalTemplate);
        }

        // Function to initialize modals
        function initializeModals() {
            $(".movies-card").click(function() {
                var title = $(this).data("title");
                var sanitizedTitle = title.replace(/[^a-zA-Z0-9]/g, "");
                $(`#${sanitizedTitle}-modal`).modal("show");

                // Fetch reviews when a movie card is clicked
                fetchReviews(title);

                // Fetch rating info for the movie
                fetchRatingInfo(title);
            });

            $(".modal").on("show.bs.modal", function() {
                $(this)
                    .find(".submit-rating")
                    .click(function() {
                        var modal = $(this).closest(".modal");
                        var title = modal.find(".modal-title").text();
                        var rating = modal.find(".rating-input").val();
                        var review = modal.find(".review-textarea").val();

                        submitRating(title, rating, review);
                    });

                $(this).on("hidden.bs.modal", function() {
                    location.reload();
                });
            });
        }

        // Function to submit rating and review
        function submitRating(title, rating, review) {
            $.ajax({
                url: "ratingfunction.php",
                method: "POST",
                data: {
                    action: "submit_rating",
                    movie_title: title,
                    rating: rating,
                    review_text: review,
                },
                success: function(response) {
                    console.log(response);
                    // Handle success (if needed)
                },
                error: function(error) {
                    console.error("Error submitting rating:", error);
                    // Handle error (if needed)
                },
            });
        }

        // Function to fetch reviews
        function fetchReviews(movieTitle) {
            $.ajax({
                url: "ratingfunction.php",
                method: "GET",
                data: {
                    action: "get_reviews_all",
                    movie_title: movieTitle,
                },
                success: function(response) {
                    var reviews = JSON.parse(response);
                    var sanitizedTitle = movieTitle.replace(/[^a-zA-Z0-9]/g, "");
                    var modalID = `#${sanitizedTitle}-modal`;
                    var modalBody = $(modalID).find(".modal-body");

                    modalBody.find(".movie-reviews").remove();

                    if (reviews.length > 0) {
                        var reviewsSection = $("<div>").addClass("movie-reviews");
                        modalBody.append("<h3>Reviews:</h3>");

                        reviews.forEach(function(review) {
                            if (review.review_text && review.review_text.trim() !== "") {
                                var reviewText = $("<p>").text(
                                    `Anonymous: ${review.review_text}`);
                                reviewsSection.append(reviewText);
                            }
                        });

                        if (reviewsSection.children().length > 0) {
                            modalBody.append(reviewsSection);
                        } else {
                            modalBody.append("<p>No valid reviews available.</p>");
                        }
                    } else {
                        modalBody.append("<p>No reviews yet.</p>");
                    }
                },
                error: function(error) {
                    console.error("Error fetching reviews:", error);
                    // Handle error (if needed)
                },
            });
        }
        //rating info nung sa movie db
        // Function to fetch rating info
        function fetchRatingInfo(movieTitle) {
            $.ajax({
                url: "ratingfunction.php",
                method: "GET",
                data: {
                    action: "get_rating_info",
                    movie_title: movieTitle,
                },
                success: function(response) {
                    var ratingInfo = JSON.parse(response);
                    if (ratingInfo !== null) {
                        var sanitizedTitle = movieTitle.replace(/[^a-zA-Z0-9]/g, "");
                        var modalID = `#${sanitizedTitle}-modal`;
                        var modalBody = $(modalID).find(".modal-header");

                        if ($(modalID).hasClass("show")) {
                            modalBody.append(`<p>Rating: ${ratingInfo.average_rating}</p>`);
                        }
                    } else {
                        console.log("No rating information available for this movie.");
                    }
                },
                error: function(error) {
                    console.error("Error fetching rating information:", error);
                    // Handle error (if needed)
                },
            });
        }
    });
    //dito yung movie list sa db
    // Function to create modals with review and rating functionalities
    function createModal(title, overview, poster_path, release_date) {
        var sanitizedTitle = title.replace(/[^a-zA-Z0-9]/g, "");
        var modalTemplate = `
            <div class="modal fade" id="${sanitizedTitle}-modal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                        </div>
                        <div class="modal-body">
                            <img src="${poster_path}" alt="${title} Poster" class="modal-poster" style="max-width: 100%; height: auto;">
                            <p>${overview}</p>
                            <p>Date Released: ${release_date}</p>
                            <select class="rating-input">
                            <option value="1">1 star</option>
                            <option value="2">2 stars</option>
                            <option value="3">3 stars</option>
                            <option value="4">4 stars</option>
                            <option value="5">5 stars</option>
                        </select>
                            <button type="button" class="btn btn-primary submit-rating">Submit Rating</button>
                        </div>
                        <div class="modal-footer">
                            <div class="movie-reviews"></div>
                        </div>
                    </div>
                </div>
            </div>`;
        $("body").append(modalTemplate);

        // Add event listeners for modals
        $(`#${sanitizedTitle}-modal`).on("show.bs.modal", function() {
            $(this)
                .find(".submit-rating")
                .click(function() {
                    var modal = $(this).closest(".modal");
                    var rating = modal.find(".rating-input").val();
                    var review = modal.find(".review-textarea").val();

                    submitRating(title, rating, review);
                });
        });

        $(`#${sanitizedTitle}-modal`).on("hidden.bs.modal", function() {
            location.reload();
        });
    }
    //submit rating nung sa movie db
    // Function to submit rating and review
    function submitRating(title, rating, review) {
        $.ajax({
            url: "ratingfunction.php",
            method: "POST",
            data: {
                action: "submit_rating",
                movie_title: title,
                rating: rating,
                review_text: review,
            },
            success: function(response) {
                console.log(response);
                // Handle success
            },
            error: function(error) {
                console.error("Error submitting rating:", error);
                // Handle error
            },
        });
    }
    //api for movies list


   
    //search
    $("#searchInput").on("input", function() {
        var searchValue = $(this).val().toLowerCase();
        $(".movies-card").each(function() {
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
