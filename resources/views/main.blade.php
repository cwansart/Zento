<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <link rel="icon" href="{!! asset('favicon.ico') !!}">

    {!! HTML::style('bootstrap/css/bootstrap.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap-theme.css') !!}
    {!! HTML::style('bootstrap/css/bootstrap.datetimepicker.css') !!}
    {!! HTML::style('select2/css/select2.min.css') !!}
    {!! HTML::style('css/main.css') !!}
    {!! HTML::script('jquery-1.11.3.min.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.min.js') !!}
    {!! HTML::script('bootstrap/js/moment.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker.js') !!}
    {!! HTML::script('bootstrap/js/bootstrap.datetimepicker-de.js') !!}
    {!! HTML::script('select2/js/select2.min.js') !!}
    {!! HTML::script('select2/js/i18n/de.js') !!}
    {!! HTML::script('js/dateFormat.js') !!}
    {!! HTML::script('js/deleteConfirm.js') !!}
    {!! HTML::script('js/main.js') !!}

</head>
<body>
@if(Auth::check())
    <div class="page-header">
        <a href="{!! route('users.index') !!}" id="zento-logo-link"><img src="{!! asset('images/zento.png') !!}" alt="Zento"></a>
        <ul class="nav nav-tabs">
            <li role="presentation" class="{!! HTML::isActive('users') !!}">{!! HTML::linkRoute('users.index', 'Benutzer') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('exams') !!}">{!! HTML::linkRoute('exams.index', 'Prüfungen') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('seminars') !!}">{!! HTML::linkRoute('seminars.index', 'Seminare') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('lists') !!}">{!! HTML::linkRoute('lists.index', 'Listen') !!}</li>
            <li role="presentation" class="{!! HTML::isActive('appointments') !!}">{!! HTML::linkRoute('appointments.index', 'Termine') !!}</li>
        </ul>
        <div class="dropdown pull-right dropdown-head">
            <button class="btn btn-default btn-margin dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
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

    @include('delete_confirm')
</div>
</body>
</html>
