@extends('main')

@section('title', 'Prüflinge')

@section('content')

    <div class="container">
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
            Noch keine Ergebnisse eingetragen!
        @endif
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection