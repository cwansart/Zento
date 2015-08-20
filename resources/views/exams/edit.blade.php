@extends('main')

@section('title', 'Prüfung vom '.$exam->date.' bearbeiten')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1>Prüfung vom {!! $exam->date !!} bearbeiten</h1>

            {!! Form::model($exam, array('class' => 'form-horizontal', 'method' => 'PUT', 'action' => ['ExamController@update', $exam->id])) !!}
            @include('exams._form')

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! Form::submit('Prüfung speichern', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
