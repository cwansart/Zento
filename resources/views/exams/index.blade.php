@extends('main')

@section('title', 'Prüfungsübersicht')

@section('content')

    <div class="container">


        <h1>Prüfungsübersicht</h1>
        @if(count($exams))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Ort</th>
                        @if(Auth::user()->is_admin)
                            <th>Aktion</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="clickable-row" data-href="{{ action('ExamController@show', [$exam->id]) }}">
                            <td>{!! $exam->date !!}</td>
                            <td>{!! $exam->addressStr() !!}</td>
                            @if(Auth::user()->is_admin)
                                <td>
                                    {!! Form::open(['action' => ['ExamController@destroy', $exam->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                                    {!! Html::linkAction('ExamController@edit', 'Bearbeiten', [$exam->id], ['class' => 'btn btn-primary btn-sm']) !!}
                                    {!! Form::submit('Löschen', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Noch keine Prüfungen vorhanden!
        @endif
    </div>

    {!! $exams->render() !!}

    <hr>

    @if(Auth::user()->is_admin)
    @include('exams.create')
    @endif

@endsection