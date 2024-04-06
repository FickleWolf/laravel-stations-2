<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movie', ['movies' => $movies]);
    }

    public function admin(){
        $movies = Movie::all();
        return view('admin', ['movies' => $movies]);
    }
}