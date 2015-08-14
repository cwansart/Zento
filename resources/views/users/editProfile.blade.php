@extends('main')

@section('title', 'Profil bearbeiten')

@section('content')

    <div class="container">
        <h1>Profil bearbeiten</h1>
        <p>Hallo {!! $user->firstname !!} {!! $user->lastname !!}, hier kannst du Profildaten ändern.</p>

        <div class="container-fluid">
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        Es gab ein paar Probleme.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::open(array('class' => 'form-horizontal', 'method' => 'PUT', 'route' => ['users.update', $user->id])) !!}
                <div class="form-group">
                    {!! Form::label('email', 'Email-Adresse', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::input('email', 'email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email-Adresse']) !!}
                    </div>
                </div>

                    <div class="form-group">
                        {!! Form::label('password', 'Passwort', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('password', 'password', '', ['class' => 'form-control', 'placeholder' => 'Passwort']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password2', 'Passwort wiederholen', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::input('password', 'password2', '', ['class' => 'form-control', 'placeholder' => 'Passwort wiederholen']) !!}
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
                // TODO: highlight the fields and a message that hey don't equal. Perhaps with a popover? ;-)
            }
        });
    </script>

@endsection