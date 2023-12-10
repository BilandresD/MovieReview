<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{

    use HasFactory;

    protected $table = 'movies';
    protected $fillable = ['title', 'overview', 'release_date', 'image_path'];

}
