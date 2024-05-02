<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Detail</title>
    <script>
        function confirmAction() {
        return confirm("本当に削除してもよろしいですか？");
    }
    </script>
</head>

<body>
    <h1>スケジュールの詳細</h1>
    <table>
        <tr>
            <th>開始時間</th>
            <td>{{ $schedule->start_time }}</td>
        </tr>
        <tr>
            <th>終了時間</th>
            <td>{{ $schedule->end_time }}</td>
        </tr>
    </table>

    <a href="/admin/schedules/{{ $schedule->id }}/edit">編集</a>

    <form action="/admin/schedules/{{ $schedule->id }}/destroy" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？')">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
    </form>
</body>

</html>
