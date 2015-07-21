@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
        <ul>
            @foreach($seminars as $seminar)

                <li>{!! $seminar!!}</li>

            @endforeach
        </ul>
    </div>

    {!! $seminars->render() !!}

@endsection