@extends('main')

@section('title', $user->firstname.' '.$user->lastname.' bearbeiten')

@section('content')

<div class="container-fluid">
    <div class="row">
        <h1>Profil von <i>{!! $user->firstname !!} {!! $user->lastname !!}</i> bearbeiten</h1>

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

        {!! Form::model($user, array('class' => 'form-horizontal', 'method' => 'PUT', 'route' => ['users.update', $user->id])) !!}
        <div class="form-group">
            {!! Form::label('firstname', 'Vorname', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('text', 'firstname', null, ['class' => 'form-control', 'placeholder' => 'Vorname', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('lastname', 'Nachname', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('text', 'lastname', null, ['class' => 'form-control', 'placeholder' => 'Nachname', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('email', 'Email-Adresse', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => 'Email-Adresse', 'required']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Passwort', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'Leer lassen zum Deaktivieren']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('birthday', 'Geburtstag', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                    {!! Form::input('text', 'birthday', null, ['class' => 'form-control', 'placeholder' => 'z. B. 01.07.1985']) !!}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('entry_date', 'Eintrittsdatum', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                <div class="input-group date datetimepicker" data-date-format="DD.MM.YYYY">
                    {!! Form::input('text', 'entry_date', null, ['class' => 'form-control', 'placeholder' => 'z. B. '.date('d.m.Y')]) !!}
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
            </div>
        </div>

        @include('location_input')

        <div class="form-group">
            {!! Form::label('group_id', 'Gruppe', ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::select('group_id', $groups, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-4"></div>

            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('active') !!} Aktives Mitglied?
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-4"></div>

            <div class="col-md-6">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('is_admin') !!} Administrator?
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Benutzer anlegen', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection