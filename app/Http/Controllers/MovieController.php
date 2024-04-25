<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Rules\UniqueTitle;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        try {
            $keyword = $request->input('keyword');

            $query = Movie::query()
                ->when($request->has('is_showing'), function ($q) use ($request) {
                    $q->where('is_showing', $request->input('is_showing') === '1');
                })
                ->when($keyword, function ($q) use ($keyword) {
                    $q->where(function ($q) use ($keyword) {
                        $q->where('title', 'like', "%$keyword%")
                            ->orWhere('description', 'like', "%$keyword%");
                    });
                });

            $movies = $query->paginate(20);

            return view('movie', ['movies' => $movies]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'エラーが発生しました。');
        }
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

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        return view('edit', ['movie' => $movie]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', new UniqueTitle],
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'is_showing' => 'boolean',
            'description' => 'required|string',
        ]);

        $movie = Movie::findOrFail($id);

        $movie->title = $validatedData['title'];
        $movie->image_url = $validatedData['image_url'];
        $movie->published_year = $validatedData['published_year'];
        $movie->is_showing = $validatedData['is_showing'] ?? false;
        $movie->description = $validatedData['description'];
        $movie->save();

        return redirect('/admin/movies')->with('success', '映画が正常に更新されました。');
    }

    public function destroy($id)
    {
        try {
            $movie = Movie::findOrFail($id);
            $movie->delete();
            return redirect('/admin/movies')->with('success', '映画が正常に削除されました。');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => '指定された映画が見つかりませんでした。'], 404);
        } catch (\Exception $e) {
            return redirect('/admin/movies')->with('error', '映画の削除中にエラーが発生しました。');
        }
    }

}