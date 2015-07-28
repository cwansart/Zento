<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>

    {!! HTML::style('bootstrap/css/bootstrap.min.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.min.css') !!}
    {!! HTML::style('select2/css/select2.min.css') !!}
    {!! HTML::style('css/main.css') !!}
    {!! HTML::style('fullcalendar-2.3.2/fullcalendar.css') !!}
    {!! HTML::script('jquery-1.11.3.min.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('bootstrap/js/moment.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker-de.js') !!}
    {!! HTML::script('select2/js/select2.min.js') !!}
    {!! HTML::script('js/main.js') !!}
    {!! HTML::script('fullcalendar-2.3.2/lib/moment.min.js') !!}
    {!! HTML::script('fullcalendar-2.3.2/fullcalendar.js') !!}

    <script>
        $(document).ready(function() {
            $('.datetimepicker').datetimepicker({
                language: 'de',
                pickTime: false,
                format: 'DD.mm.yyyy'
            });

            $('#calendar').fullCalendar({
                // put your options and callbacks here
            })
        });
    </script>

</head>
<body>

<ul class="nav nav-tabs">
    <li>
        {{-- we could add the application logo here, if we will keep this  --}}
            <img style="max-width: 42px; max-height: 42px;" src="http://icons.iconarchive.com/icons/custom-icon-design/pretty-office-8/128/Accept-icon.png" alt="">

    </li>

    <li role="presentation" class="{!! HTML::isActive('users') !!}">{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
    <li role="presentation" class="{!! HTML::isActive('exams') !!}">{!! HTML::linkRoute('exams.index', 'Prüfungen') !!}</li>
    <li role="presentation" class="{!! HTML::isActive('seminars') !!}">{!! HTML::linkRoute('seminars.index', 'Seminare') !!}</li>
    <li role="presentation" class="{!! HTML::isActive('appointments') !!}">{!! HTML::linkRoute('appointments.index', 'Termine') !!}</li>

    <ul class="nav nav-tabs navbar-right">
        <a href="/edit_profile">
            <img style="max-width: 42px; max-height: 42px;" src="images/avatar-default.png" alt="Selfhtml">
        </a>
    </ul>
</ul>

<div class="container">
    @yield('content')
</div>
</body>
</html>
