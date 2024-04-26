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
        <form action='/admin/movies/{{$movie->id}}/update' method="POST">
            @csrf
            @method('PATCH') <!-- HTTPメソッドをオーバーライド -->
            <label for="title">タイトル</label>
            <input type="text" id="title" name="title" value="{{ $movie->title }}" required>
            <br/>

            <label for="genre">ジャンル</label>
            <input type="text" id="genre" name="genre" value="{{ $movie->genre ? $movie->genre->name : '' }}" required>
            <br/>


            <label for="image_url">画像URL</label>
            <input type="url" id="image_url" name="image_url" value="{{ $movie->image_url }}" required>
            <br/>

            <label for="published_year">公開年</label>
            <input type="number" id="published_year" name="published_year" value="{{ $movie->published_year }}" required>
            <br/>

            <input type="checkbox" id="is_showing" name="is_showing" {{ $movie->is_showing ? 'checked' : '' }}>
            <label for="is_showing">公開中</label>
            <br/>

            <label for="description">概要：</label><br/>
            <textarea id="description" name="description" rows="4" cols="50" wrap="soft" required>{{ $movie->description }}</textarea>
            <br/>

            <input type="submit" value="送信">
        </form>
    </div>
</body>
</html>
