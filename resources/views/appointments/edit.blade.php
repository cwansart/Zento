@extends('main')

@section('title', 'Termin „'.$appointment->title.'” bearbeiten')

@section('content')

<div class="container-fluid">
	<h1>Termin „{!! $appointment->title !!}” vom {!! $appointment->start !!}</h1>
    <div class="row">

        {!! Form::model($appointment, array('class' => 'form-horizontal', 'method' => 'PUT', 'route' => ['appointments.update', $appointment->id])) !!}
        @include('appointments._form')

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Termin speichern', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}

    </div>
<hr>
	{!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
</div>
@endsection
