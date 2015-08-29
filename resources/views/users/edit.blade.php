@extends('main')

@section('title', $user->firstname.' '.$user->lastname.' bearbeiten')

@section('content')

<div class="container-fluid">
	<h1>Profil von <i>{!! $user->firstname !!} {!! $user->lastname !!}</i> bearbeiten</h1>
    <div class="row">

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
<hr>
	{!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
</div>
@endsection
