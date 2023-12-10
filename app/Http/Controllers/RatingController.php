<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function submitRating(Request $request)
    {
        if ($request->action === 'submit_rating') {
            $rating = new Rating();

            $result = $rating->submitRating($request->movie_title, $request->rating, $request->review_text);
            if ($result) {
                return 'Rating and review submitted successfully.';
            } else {
                return 'Error submitting rating and review.';
            }
        }
    }

    public function getRatingInfo(Request $request)
    {
        if ($request->action === 'get_rating_info' && $request->has('movie_title')) {
            $rating = new Rating();

            $ratingInfo = $rating->getAverageRatingAndTotalReviews($request->movie_title);
            return response()->json($ratingInfo);
        }
    }

    public function getReviewsAll(Request $request)
    {
        if ($request->action === 'get_reviews_all' && $request->has('movie_title')) {
            $rating = new Rating();

            $reviews = $rating->getReviewsByMovieTitle($request->movie_title);
            return response()->json($reviews);
        }
    }
}
