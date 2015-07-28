@extends('main')

@section('title', 'Termine')

@section('content')

    <div class="container">
        <h1>Termine</h1>

        <div id='calendar'></div>

    </div>

    {!! $appointments->render() !!}

    <hr>

@endsection