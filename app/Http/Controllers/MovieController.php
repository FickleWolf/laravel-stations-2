<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Genre;
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
        try {
            $validatedData = $request->validate([
                'title' => ['required', 'string', 'max:255', new UniqueTitle],
                'genre' => 'required|string',
                'image_url' => 'required|url',
                'published_year' => 'required|integer',
                'is_showing' => 'boolean',
                'description' => 'required|string',
            ]);
            DB::transaction(function () use ($validatedData) {
                $genre = Genre::firstOrCreate(['name' => $validatedData['genre']]);

                $movie = new Movie();
                $movie->title = $validatedData['title'];
                $movie->genre_id = $genre->id;
                $movie->image_url = $validatedData['image_url'];
                $movie->published_year = $validatedData['published_year'];
                $movie->is_showing = $validatedData['is_showing'] ?? false;
                $movie->description = $validatedData['description'];
                $movie->save();
            });

            return redirect('/admin/movies')->with('success', '映画が正常に追加されました.');
        } catch (\Exception $e) {
            return response()->json(['error' => '映画の追加に失敗しました。'], 500);
        }
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
            'genre' => 'required|string',
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'is_showing' => 'boolean',
            'description' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $movie = Movie::findOrFail($id);

            $newGenre = Genre::firstOrCreate(['name' => $validatedData['genre']]);

            $currentGenre = $movie->genre;

            if ($currentGenre->id !== $newGenre->id) {
                $movie->genre_id = $newGenre->id;
            }

            $movie->title = $validatedData['title'];
            $movie->image_url = $validatedData['image_url'];
            $movie->published_year = $validatedData['published_year'];
            $movie->is_showing = $validatedData['is_showing'] ?? false;
            $movie->description = $validatedData['description'];
            $movie->save();

            DB::commit();

            return redirect('/admin/movies')->with('success', '映画が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollback();

            return back()->withInput()->withErrors(['error' => '映画の更新中にエラーが発生しました。']);
        }
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