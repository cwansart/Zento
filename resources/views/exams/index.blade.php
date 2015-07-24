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
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="clickable-row" data-href="{{ action('ExamController@show', [$exam->id]) }}">
                            <td>{!! $exam->date->format('d.m.Y') !!}</td>
                            <td>{!! $exam->addressStr() !!}</td>
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

    @include('exams.create')

@endsection