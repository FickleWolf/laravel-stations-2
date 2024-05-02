<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Sheet;
use App\Models\Schedule;
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

    public function detail($id)
    {
        $movie = Movie::findOrFail($id);
        $schedules = $movie->schedules()->orderBy('start_time')->get();
        return view('detail', ['movie' => $movie, 'schedules' => $schedules]);
    }


    public function admin()
    {
        $movies = Movie::all();
        return view('admin', ['movies' => $movies]);
    }

    public function adminDetail($id)
    {
        $movie = Movie::findOrFail($id);
        $schedules = $movie->schedules()->orderBy('start_time')->get();
        return view('adminDetail', ['movie' => $movie, 'schedules' => $schedules]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255', new UniqueTitle],
            'genre' => 'required|string',
            'image_url' => 'required|url',
            'published_year' => 'required|integer',
            'is_showing' => 'boolean',
            'description' => 'required|string',
        ]);
        try {
            DB::beginTransaction(); // トランザクション開始

            $genre = Genre::firstOrCreate(['name' => $validatedData['genre']]);

            $movie = new Movie();
            $movie->title = $validatedData['title'];
            $movie->genre_id = $genre->id;
            $movie->image_url = $validatedData['image_url'];
            $movie->published_year = $validatedData['published_year'];
            $movie->is_showing = $validatedData['is_showing'] ?? false;
            $movie->description = $validatedData['description'];
            $movie->save();

            DB::commit(); // トランザクションをコミット

            return redirect('/admin/movies')->with('success', '映画が正常に追加されました.');
        } catch (\Exception $e) {
            DB::rollback(); // トランザクションをロールバック
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

    public function schedules()
    {
        $moviesWithSchedules = Movie::has('schedules')
            ->with([
                'schedules' => function ($query) {
                    $query->orderBy('start_time');
                }
            ])
            ->get();

        return view('schedules', ['moviesWithSchedules' => $moviesWithSchedules]);
    }

    public function scheduleCreate($id)
    {
        return view('scheduleCreate', ['movie_id' => $id]);
    }

    public function scheduleStore(Request $request, $id)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        try {
            $schedule = new Schedule();
            $schedule->movie_id = $validatedData['movie_id'];
            $schedule->start_time = $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time']; // start_time_dateを修正
            $schedule->end_time = $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time']; // end_time_dateを修正
            $schedule->save();

            return redirect('/admin/movies/' . $id)->with('success', 'スケジュールが正常に作成されました。'); // リダイレクト時のパラメータを修正
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'スケジュールの作成中にエラーが発生しました。']);
        }
    }


    public function scheduleDetail($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('scheduleDetail', ['schedule' => $schedule]);
    }

    public function scheduleEdit($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('scheduleEdit', ['schedule' => $schedule]);
    }

    public function scheduleUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'movie_id' => 'required',
            'start_time_date' => 'required|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date' => 'required|date_format:Y-m-d',
            'end_time_time' => 'required|date_format:H:i',
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->start_time = $validatedData['start_time_date'] . ' ' . $validatedData['start_time_time'];
            $schedule->end_time = $validatedData['end_time_date'] . ' ' . $validatedData['end_time_time'];

            $schedule->save();

            return redirect('/admin/movies/' . $schedule->movie_id)->with('success', 'スケジュールの更新が正常に完了しました。');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'スケジュールの更新中にエラーが発生しました。']);
        }
    }


    public function scheduleDestroy($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);
            $schedule->delete();
            return redirect('/admin/movies/' . $schedule->movie_id)->with('success', 'スケジュールの削除が正常に完了しました。');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => '指定されたスケジュールが見つかりませんでした。'], 404);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'スケジュールの削除中にエラーが発生しました。']);
        }
    }

    public function sheets()
    {
        $sheets = Sheet::all();
        return view('sheets', ['sheets' => $sheets]);
    }
}