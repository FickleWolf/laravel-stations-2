<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Rules\UniqueTitle;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        return view('movie', ['movies' => $movies]);
    }

    public function admin()
    {
        $movies = Movie::all();
        return view('admin', ['movies' => $movies]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', new UniqueTitle],
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'is_showing' => 'boolean',
            'description' => 'required|string',
        ]);

        $movie = new Movie();
        $movie->title = $validatedData['title'];
        $movie->image_url = $validatedData['image_url'];
        $movie->published_year = $validatedData['published_year'];
        $movie->is_showing = $validatedData['is_showing'] ?? false;
        $movie->description = $validatedData['description'];
        $movie->save();

        return redirect('/admin/movies')->with('success', '映画が正常に追加されました。');
    }
}