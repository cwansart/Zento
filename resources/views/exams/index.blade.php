@extends('main')

@section('title', 'Prüfungsübersicht')

@section('content')

    <div class="container">
        <ul>
            @foreach($exams as $exam)

                <li>{!! $exam !!}</li>

            @endforeach
        </ul>
    </div>

    {!! $exams->render() !!}

@endsection