@extends('main')

@section('title', 'Teilnehmer')

@section('content')

    <div class="container">
        @if(count($seminarUsers))
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
        @else
            Keine Benutzer im Seminar eingetragen!
        @endif
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection