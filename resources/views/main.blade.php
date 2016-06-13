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

    @if (session('first_login'))
            <div class="modal fade" id="firstLogin" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Willkommen bei Zento</h4>
                        </div>
                        <div class="modal-body">
                            <p style="font-weight: bold">Was ist Zento?</p>

                            <p>Zento ist ein Online Tool zum Verwalten eurer Mitglieder, Prüfungen, Seminare und Termine.</p>

                            <p style="font-weight: bold">Was kannst du mit Zento machen?</p>

                            <p>
                            @if (Auth::user()->is_admin)
                                Mit Zento bist du in der Lage, Mitglieder, Prüfungen, Seminare und Termine anzulegen und
                                zu verwalten. Zum Beispiel lassen sich angelegte Mitglieder zu einer Prüfung oder einem
                                Seminar hinzufügen, um so den Überblick über vergangene Prüfungen zu behalten.
                            @else
                                Mit Zento bist du in der Lage, Mitglieder, Prüfungen und Seminare aus der Vergangenheit
                                einzusehen und den Trainingsverlauf der einzelnen Mitglieder nachzuvollziehen.
                            @endif
                            </p>
                            <p>
                                Mit Hilfe des Tabs <i>Listen</i> lassen sich ganz einfach Listen für verschiedene Zwecke, zum
                                Beispiel zur Planung eines Seminars, generieren und ausdrucken. Zusätzlichen können
                                Termine angelegt und gepflegt werden. Dabei ermöglicht der Termintyp <i>Training</i> eine
                                zuverlässige Planung von Trainingsterminen und der anwesenden Trainer.
                            </p>
                            <p>Viel Spaß!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-no-border" data-dismiss="modal">Schließen</button>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                $(function() {
                    $('#firstLogin').modal('show');
                });
            </script>
        @endif

    @yield('content')

    @include('delete_confirm')
</div>
</body>
</html>
