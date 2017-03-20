<!-- resources/views/layout/global.blade.divhdiv -->

<!DOCTYPE HTML>
<html>
<head>
    <title>{{ $title }}</title>
    {!! Html::style('css/bootstrap.min.css') !!}
</head>
<body>
    <div class='container'>
    @yield('content')
    </div>
</body>
</html>