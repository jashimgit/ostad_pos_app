<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    

    // show home page

    public function index() 
    {
        return view('home-page');
    }
}
