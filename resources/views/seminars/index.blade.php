@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
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
                    <tr>
                        <td>{!! $seminar->date !!}</td>
                        <td>{!! $seminar->title !!}</td>
                        <td>{!! $seminar->location_id !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {!! $seminars->render() !!}

@endsection