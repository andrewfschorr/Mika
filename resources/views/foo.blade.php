<!DOCTYPE html>
<html>
<head>
    <title>Yo world!</title>
</head>
<body>
    <h1>hiiii</h1>
    <ul>
        @foreach ($tasks as $task)
            <li>
                <a href="/foo/{{$task->id}}">{{ $task->body }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>