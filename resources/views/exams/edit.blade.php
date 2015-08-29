@extends('main')

@section('title', 'Prüfung vom '.$exam->date.' bearbeiten')

@section('content')
    <div class="container-fluid">
		<h1>Prüfung vom {!! $exam->date !!} bearbeiten</h1>
        <div class="row">
            
            {!! Form::model($exam, array('class' => 'form-horizontal', 'method' => 'PUT', 'action' => ['ExamController@update', $exam->id])) !!}
            @include('exams._form')

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! Form::submit('Prüfung speichern', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
	<hr>
	{!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

@endsection
