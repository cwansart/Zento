@extends('main')

@section('title', 'Prüfungsübersicht')

@section('content')

    <div class="container">
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
                        <td>{!! $exam->date !!}</td>
                        <td>{!! $exam->addressStr() !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {!! $exams->render() !!}

@endsection