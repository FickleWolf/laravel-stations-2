<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script>
        function confirmAction() {
        return confirm("本当に削除してもよろしいですか？");
    }
    </script>
    <title>Admin</title>
</head>
<body>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif
    <a href='/admin/movies/create'>映画の作成</a>
    <table>
        <thead>
            <tr>
                <th>タイトル</th>
                <th>公開年</th>
                <th>上映状況</th>
                <th>概要</th>
                <th>画像</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie->title }}</td>
                    <td>{{ $movie->published_year }}年</td>
                    <td>{{ ($movie->is_showing) ? '上映中' : '上映予定' }}</td>
                    <td>{{ $movie->description }}</td>
                    <td><img src='{{ $movie->image_url }}'/></td>
                    <td><a href='/admin/movies/{{ $movie->id }}/edit'>編集</a></td>
                    <td>
                        <form action="/admin/movies/1000/destroy" method="POST" onsubmit="return confirmAction()">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>