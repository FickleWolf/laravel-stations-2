<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>スケジュール更新</title>
</head>

<body>
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <h1>スケジュール作成</h1>
    <form action="/admin/schedules/{{$schedule->id}}/update" method="POST">
        @csrf
        @method('PATCH') <!-- HTTPメソッドをオーバーライド -->
        <div>
            <label for="start_date">開始日付:</label>
            <input type="date" id="start_date" name="start_date" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d') }}" required>
        </div>
        <div>
            <label for="start_time">開始時刻:</label>
            <input type="time" id="start_time" name="start_time" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
        </div>
        <div>
            <label for="end_date">終了日付:</label>
            <input type="date" id="end_date" name="end_date" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('Y-m-d') }}" required>
        </div>
        <div>
            <label for="end_time">終了時刻:</label>
            <input type="time" id="end_time" name="end_time" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
        </div>
        <button type="submit">スケジュール更新</button>
    </form>
</body>

</html>
