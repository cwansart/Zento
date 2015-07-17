<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    {!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.min.css') !!}
    {!! HTML::script('jquery-1.11.3.min.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}

</head>
<body>

<ul class="nav nav-tabs">
    <li>
        {{-- we could add the application logo here, if we will keep this  --}}
            <img style="max-width: 42px; max-height: 42px;" src="http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/128/Accept-icon.png" alt="">

    </li>

    <li role="presentation" class="{!! HTML::isActive('users') !!}">{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
    <li role="presentation" class="{!! HTML::isActive('exams') !!}">{!! HTML::linkRoute('exams.index', 'Prüfungen') !!}</li>
</ul>

<div class="container">
    @yield('content')
</div>
</body>
</html>
