@extends('main')

@section('title', 'Prüflinge '.$results->first()->exam->date->format('d.m.Y'))

@section('content')

    <div class="container">
        <h1>Prüflinge vom {!! $results->first()->exam->date->format('d.m.Y') !!}</h1>
        @if(count($results))
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Ergebnis</th>
                </tr>
                </thead>
                <tbody>
                @foreach($results as $result)
                    <tr class="clickable-row" data-href="{{ action('UserController@show', [$result->user->id]) }}">
                        <td>{!! $result->user->firstname !!}</td>
                        <td>{!! $result->user->lastname !!}</td>
                        <td>{!! $result->result !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Noch keine Ergebnisse eingetragen!</p>
        @endif

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection