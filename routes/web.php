<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;

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
    return view('admin');
});

Route::post('/admin', [RatingController::class, 'submitRating']);
Route::get('/admin', [RatingController::class, 'getRatingInfo'])->name('ratings.get');




Route::post('/admin', [UserController::class, 'getAllUsers'])->name('users.get');



