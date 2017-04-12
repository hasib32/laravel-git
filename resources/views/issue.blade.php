<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel Git</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Styles -->
</head>
<body>
<ul class="nav nav-tabs">
    <li role="presentation"><a href='{{ route('issues') }}'>Issues</a></li>
    <li role="presentation"><a href='{{ route('repos') }}'>Repositories</a></li>
</ul>

<div class="container">
    <h2>All Issues</h2>
    <ul class="list-group">
        @foreach($issues as $issue)
            <h3>Issue # {{ $loop->index+1 }}</h3>

            @foreach ($issue as $key => $value)

                @if (is_string($value))
                    <li class="list-group-item">{!! $key !!} : {!! $value !!}</li>
                @endif

            @endforeach

        @endforeach
    </ul>
</div>
</body>
</html>
