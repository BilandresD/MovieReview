<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Ensure you import the Controller class

class HomeController extends Controller
{
    public function __construct()
    {
        // Your constructor code here, if needed
    }

    public function index()
    {
        // Code for the index method
        return view('index'); // Replace 'index' with your actual view name
    }

    public function admin()
    {
        // Code for the admin method
        return view('admin');
    }

    public function user()
    {
        // Code for the user method
        return view('dashboard');
    }
}
?>
