<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">

    {!! HTML::style('bootstrap/css/bootstrap.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap.datetimepicker.css') !!}
    {!! HTML::style('select2/css/select2.min.css') !!}
    {!! HTML::style('fullcalendar-2.3.2/fullcalendar.css') !!}
    {!! HTML::style('css/main.css') !!}
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
@if(Auth::check())
    <div class="page-header">
        <img src="{!! asset('images/zento.png') !!}" alt="">
        <ul class="nav nav-tabs">
            <li role="presentation" class="{!! HTML::isActive('users') !!}">{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('exams') !!}">{!! HTML::linkRoute('exams.index', 'Prüfungen') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('seminars') !!}">{!! HTML::linkRoute('seminars.index', 'Seminare') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('appointments') !!}">{!! HTML::linkRoute('appointments.index', 'Termine') !!}</li>
        </ul>
        <div class="dropdown pull-right dropdown-head">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {!! Auth::user()->firstname !!}
                {!! Auth::user()->lastname !!}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a href="{!! action('UserController@editProfile') !!}">Profil bearbeiten</a></li>
                <li><a href="{!! action('Auth\AuthController@getLogout') !!}">Abmelden</a></li>
            </ul>
        </div>
    </div>
@endif

<div class="container">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            Es gab ein paar Probleme:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            {{ session('status') }}
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
