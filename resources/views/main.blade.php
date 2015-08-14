<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    {!! HTML::style('bootstrap/css/bootstrap.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.css') !!}
    {!! HTML::style('select2/css/select2.min.css') !!}
    {!! HTML::style('css/main.css') !!}
    {!! HTML::style('fullcalendar-2.3.2/fullcalendar.css') !!}
    {!! HTML::script('jquery-1.11.3.min.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('bootstrap/js/moment.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker-de.js') !!}
    {!! HTML::script('select2/js/select2.min.js') !!}
    {!! HTML::script('select2/js/i18n/de.js') !!}
    {!! HTML::script('js/main.js') !!}
    {!! HTML::script('fullcalendar-2.3.2/lib/moment.min.js') !!}
    {!! HTML::script('fullcalendar-2.3.2/fullcalendar.js') !!}
    {!! HTML::script('fullcalendar-2.3.2/lang/de.js') !!}

    <script>
        $(document).ready(function() {
            $('.datetimepicker').datetimepicker({
                language: 'de',
                pickTime: false,
                format: 'DD.mm.yyyy'
            });
        });
    </script>

</head>
<body>
<div class="page-header">
    <img src="{!! asset('images/zento.png') !!}" alt="">
    <ul class="nav nav-tabs">
        <li role="presentation" class="{!! HTML::isActive('users') !!}">{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
        <li role="presentation" class="{!! HTML::isActive('exams') !!}">{!! HTML::linkRoute('exams.index', 'Prüfungen') !!}</li>
        <li role="presentation" class="{!! HTML::isActive('seminars') !!}">{!! HTML::linkRoute('seminars.index', 'Seminare') !!}</li>
        <li role="presentation" class="{!! HTML::isActive('appointments') !!}">{!! HTML::linkRoute('appointments.index', 'Termine') !!}</li>
    </ul>
    <ul class="navbar-right">
        <li role="presentation">
            <a href="{!! action('UserController@logout') !!}">Abmelden</a>
        </li>
        <a href="/edit_profile">
            <img style="max-width: 40px; max-height: 40px;" src="{!! asset('images/avatar-default.png') !!}" alt="Selfhtml">
        </a>
    </ul>
</div>

<div class="container">
    @yield('content')
</div>
</body>
</html>
