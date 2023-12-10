<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});



Route::post('/users', [UserController::class, 'getAllUsers'])->name('users.get');
Route::get('/getAllMovies', [UserController::class, 'getAllMovies'])->name('movies.get');






Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::get('/login', function () {
    return view('login');
})->name('login');






Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::check()) {
            // Check the role of the authenticated user
            $role = Auth::user()->role;

            // Redirect based on user role
            if ($role === 'admin') {
                return redirect()->route('admin.index'); // Redirect admin to admin dashboard
            } elseif ($role === 'user') {
                return redirect()->route('user.index'); // Redirect user to user dashboard
            }
        }

        // If the role is not defined or authentication fails, redirect to default dashboard
        return redirect()->route('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'userAuth:admin'])->group(function () {
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin.index');
});

Route::middleware(['auth', 'userAuth:user'])->group(function () {
    Route::get('/admin', [HomeController::class, 'user'])->name('user.index');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
