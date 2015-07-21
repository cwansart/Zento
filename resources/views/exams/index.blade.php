@extends('main')

@section('title', 'Prüfungsübersicht')

@section('content')

    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Datum</td>
                    <td>Ort</td>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                    <tr>
                        <td>{!! $exam->date !!}</td>
                        <td>{!! $exam->addressStr() !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {!! $exams->render() !!}

@endsection