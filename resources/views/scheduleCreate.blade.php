<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール作成</title>
</head>

<body>
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <h1>スケジュール作成</h1>
    <form action="/admin/movies/{{$movie_id}}/schedules/store" method="POST">
        @csrf
        <input type="hidden" name="movie_id" value="{{$movie_id}}">
        <div>
            <label for="start_time_date">開始日付:</label>
            <input type="date" id="start_time_date" name="start_time_date" required>
        </div>
        <div>
            <label for="start_time_time">開始時刻:</label>
            <input type="time" id="start_time_time" name="start_time_time" required>
        </div>
        <div>
            <label for="end_time_date">終了日付:</label>
            <input type="date" id="end_time_date" name="end_time_date" required>
        </div>
        <div>
            <label for="end_time_time">終了時刻:</label>
            <input type="time" id="end_time_time" name="end_time_time" required>
        </div>
        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <button type="submit">スケジュール作成</button>
    </form>
</body>

</html>
