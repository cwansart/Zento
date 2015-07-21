@extends('main')

@section('title', 'Teilnehmer')

@section('content')

    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seminarUsers as $seminarUser)
                <tr class="clickable-row" data-href="{{ action('UserController@show', [$seminarUser->id]) }}">
                    <td>{!! $seminarUser->firstname !!}</td>
                    <td>{!! $seminarUser->lastname !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection