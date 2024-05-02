<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Detail</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>{{ $movie->title }}</h1>
    <img src="{{ $movie->image_url }}" alt="{{ $movie->title }}">
    <p><strong>公開年:</strong> {{ $movie->published_year }}</p>
    <p><strong>ジャンル:</strong> {{ $movie->genre->name }}</p>
    <p><strong>概要:</strong> {{ $movie->description }}</p>

    <h2>上映スケジュール</h2>
    <a href='/admin/movies/{{ $movie->id }}/schedules/create'>スケジュールの作成<a>
    <table>
        <thead>
            <tr>
                <th>開始時間</th>
                <th>終了時間</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($schedules as $schedule)
        <tr>
            <td>{{\Carbon\Carbon::parse($schedule->start_time)->format('H:i')}}</td>
            <td>{{\Carbon\Carbon::parse($schedule->end_time)->format('H:i')}}</td>
            <td><a href='/admin/schedules/{{$schedule->id}}'>詳細</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</body>

</html>
