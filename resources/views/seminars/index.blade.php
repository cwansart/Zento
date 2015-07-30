@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <h1>Seminarübersicht</h1>
        @if(count($seminars))

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Titel</th>
                        <th>Ort</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seminars as $seminar)
                        <tr class="clickable-row" data-href="{{ action('SeminarController@show', [$seminar->id]) }}">
                            <td>{!! $seminar->date->format('d.m.Y') !!}</td>
                            <td>{!! $seminar->title !!}</td>
                            <td>{!! $seminar->addressStr() !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Noch keine Seminare vorhanden!
        @endif
    </div>

    {!! $seminars->render() !!}

    <hr>

    @include('seminars.create')

@endsection