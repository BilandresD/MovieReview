<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public $mysql;




    public function insert(Request $request, $table, $data)
    {
        $table_columns = implode(',', array_keys($data));
        $table_values = "'" . implode("','", $data) . "'";
        $sql = "INSERT INTO $table($table_columns) VALUES ($table_values)";
        $success = DB::insert($sql);

        if ($success) {
            return response()->json(['error' => 'Error in SQL query'], 500);
        }

        return response()->json(['message' => 'Record inserted successfully']);
    }


    public function getAllMovies()
    {
        $movies = DB::select("SELECT * FROM movies");

        foreach ($movies as $movie) {
            // Assuming 'image_path' is the column name storing the image path
            $movie->image_path = asset('storage/' . $movie->image_path);
        }

        return response()->json($movies);
    }


    public function insertMovie($table, $columns, $values)
    {
        $columnNames = implode(', ', $columns);
        $placeholders = implode(', ', array_fill(0, count($values), '?'));

        $sql = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";
        $success = DB::insert($sql, $values);

        if ($success) {
            return response()->json(['message' => 'Movie inserted successfully']);
        }

        return response()->json(['error' => 'Error inserting movie'], 500);
    }

    public function deleteMovies($id)
    {
        $deleted = DB::delete("DELETE FROM `movies` WHERE `id` = ?", [$id]);

        if ($deleted) {
            return response()->json(['message' => 'Movie deleted successfully']);
        }

        return response()->json(['error' => 'Error deleting movie'], 500);
    }




    public function getAllUsers()
    {
        $users = DB::table('users')->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        return response()->json($users, 200);
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $result = $this->mysql->query($sql);
        return $result->fetch_assoc();
    }

    public function insertMovieRating($movie_title, $rating, $review)
    {
        $result = DB::table('ratings')->updateOrInsert(
            ['movie_title' => $movie_title],
            ['rating' => $rating, 'review' => $review]
        );

        return $result ? true : false;
    }

    public function deleteUsers($id)
    {
        $result = DB::table('users')->where('id', $id)->delete();

        return $result ? true : false;
    }

    public function updateUsers($table, $data, $condition)
    {
        $result = DB::table($table)->where($condition)->update($data);

        return $result ? true : false;
    }

    public function getAllRatings()
    {
        $ratings = DB::table('ratings')->get();

        return $ratings->isEmpty() ? [] : $ratings->toArray();
    }

    public function deleteRating($id)
    {
        $result = DB::table('ratings')->where('id', $id)->delete();

        return $result ? true : false;
    }

    public function fetchMovies()
    {
        $movies = DB::table('movies')->get();

        return $movies->isEmpty() ? '[]' : $movies->toJson();
    }


    function isUserLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }


    function logout()
    {
        // logout.php
        session_start(); // Start the session

        // Unset all of the session variables
        $_SESSION = array();

        // Destroy the session.
        session_destroy();

        // Redirect to index.php
        header("Location: dashboard.php");
        exit;
    }
}
