@extends('main')

@section('title', 'Profil bearbeiten')

@section('content')

    {{--- We still need this, since this one is triggered by JavaScript! ---}}
    <div class="alert alert-danger" id="password-error-info" role="alert" style="display:none;">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Es gab ein paar Probleme:<br><br>
        <ul>
            <li>Die eingegebenen Passwörter stimmen nicht überein!</li>
        </ul>
    </div>

    <div class="container">
        <h1>Profil bearbeiten</h1>
        <p>Hallo {!! $user->firstname !!} {!! $user->lastname !!}, hier kannst du Profildaten ändern.</p>

        <div class="container-fluid">
            <div class="row">
                {!! Form::open(array('class' => 'form-horizontal', 'method' => 'PUT', 'action' => ['UserController@updateProfile', $user->id], 'autocomplete' => 'off')) !!}
                {{-- This is a little bugfix to turn off autocompletion for the email address and password fields. --}}
                <input type="text" style="display:none">
                <input type="password" style="display:none">

                <div class="form-group">
                    {!! Form::label('email', 'Email-Adresse', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => 'derzeitig: '.$user->email]) !!}
                        <div class="help-block">
                            E-Mail-Feld leer lassen, um aktuelle E-Mail-Adresse beizubehalten.
                        </div>
                    </div>
                </div>



                <div class="form-group" id="password-group1">
                    {!! Form::label('password', 'Passwort', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('password', 'password', '', ['class' => 'form-control', 'placeholder' => 'Passwort']) !!}
                    </div>
                </div>
                <input type="password" style="display:none">

                <div class="form-group" id="password-group2">
                    {!! Form::label('password2', 'Passwort wiederholen', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('password', 'password2', '', ['class' => 'form-control', 'placeholder' => 'Passwort wiederholen']) !!}
                        <div class="help-block">
                            Passwort-Felder leer lassen, um aktuelles Passwort beizubehalten.
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        {!! Form::submit('Daten speichern', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>

    <script>
        $("form").submit(function (e) {
            e.preventDefault();
            if($('#password').val() == $('#password2').val()) {
                this.submit();
            } else {
                $('#password-group1').addClass('has-error');
                $('#password-group2').addClass('has-error');
                $('#password-error-info').show();
                $('#password2').focus();
            }
        });
    </script>

@endsection