@extends('main')

@section('title', $user->firstname.' '.$user->lastname.' bearbeiten')

@section('content')

<div class="container-fluid">
    <div class="row">
        <h1>Profil von <i>{!! $user->firstname !!} {!! $user->lastname !!}</i> bearbeiten</h1>

        {!! Form::model($user, array('class' => 'form-horizontal', 'method' => 'PUT', 'route' => ['users.update', $user->id])) !!}
        @include('users._form')

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
                {!! Form::submit('Benutzerdaten speichern', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection
