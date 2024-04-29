<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Reservation</title>
    <style>
        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td>スクリーン</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        @foreach (['a', 'b', 'c'] as $row)
            <tr>
                @for ($i = 1; $i <= 5; $i++)
                    <td>{{ $row }}-{{ $i }}</td>
                @endfor
            </tr>
        @endforeach
    </table>
</body>

</html>
