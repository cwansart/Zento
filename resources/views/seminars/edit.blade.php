@extends('main')

@section('title', 'Seminar '.$seminar->title.' vom '.$seminar->date.' bearbeiten')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <h1>Seminar {!! $seminar->title !!} vom {!! $seminar->date !!} bearbeiten</h1>

            {!! Form::model($seminar, array('class' => 'form-horizontal', 'method' => 'PUT', 'action' => ['SeminarController@update', $seminar->id])) !!}
            @include('seminars._form')

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! Form::submit('Seminar speichern', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
