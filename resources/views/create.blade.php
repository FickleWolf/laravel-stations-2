<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MovieCreate</title>
</head>
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div>
        
        <form action="/admin/movies/store" method="post">
            @csrf
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title" required>
            <br/>

            <label for="title">ジャンル</label>
            <input type="text" id="genre" name="genre" required>
            <br/>

            <label for="image_url">画像URL</label>
            <input type="url" id="image_url" name="image_url" required>
            <br/>

            <label for="published_year">公開年</label>
            <input type="number" id="published_year" name="published_year" required>
            <br/>

            <input type="checkbox" id="is_showing" name="is_showing" value="1">
            <label for="is_showing">公開中</label>
            <br/>

            <label for="description">概要：</label><br/>
            <textarea id="description" name="description" rows="4" cols="50" wrap="soft" required></textarea>
            <br/>

            <input type="submit" value="送信">
        </form>
    </div>
</body>
</html>