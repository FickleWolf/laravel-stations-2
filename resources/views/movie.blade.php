<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
</head>
<body>
    <form action="/movies" method="GET">
        <label for="keyword">キーワード:</label>
        <input type="text" id="keyword" name="keyword" placeholder="キーワードを入力">
        <br>
        <input type="radio" id="all" name="is_showing" value="all" checked>
        <label for="all">すべて</label>
        <input type="radio" id="upcoming" name="is_showing" value="0">
        <label for="upcoming">公開予定</label>
        <input type="radio" id="current" name="is_showing" value="1">
        <label for="current">公開中</label>
        <br>
        <button type="submit">検索</button>
    </form>

    <div>
        @if ($movies->isEmpty())
            <p>該当する映画が見つかりませんでした。</p>
        @else
            @foreach ($movies as $movie)
                <div>
                    <p>{{ $movie->title }}</p>
                    <img src='{{ $movie->image_url }}' alt="{{ $movie->title }}">
                </div>
            @endforeach
            {{ $movies->links() }} <!-- ページネーションリンクを表示 -->
        @endif
    </div>
</body>
</html>
