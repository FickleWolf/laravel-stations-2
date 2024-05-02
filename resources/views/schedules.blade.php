<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules</title>
</head>

<body>
    <h1>Schedules</h1>
    @foreach($moviesWithSchedules as $movie)
        <h2>{{ $movie->id }} - {{ $movie->title }}</h2>
        <ul>
            @foreach($movie->schedules as $schedule)
                <li><a href="/admin/schedules/{{ $schedule->id }}">{{ $schedule->start_time }} - {{ $schedule->end_time }}</a></li>
            @endforeach
        </ul>
    @endforeach
</body>

</html>
