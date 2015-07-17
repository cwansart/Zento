<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    {!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.min.css') !!}
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}

</head>
<body>
<nav class="navbar navbar-default">
    <ul class="nav nav-tabs nav-justified">
        <li>{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
    </ul>
</nav>
<div class="container">
    @yield('content')
</div>
</body>
</html>
