@extends('main')

@section('title', 'Teilnehmer'.' "'.$title.'"')

@section('content')

    <div class="container">
        <h1>Teilnehmer des Seminars "{!! $title !!}"</h1>
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
            <p>Keine Benutzer im Seminar eingetragen!</p>
        @endif

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection