@extends('main')

@section('title', 'Termine')

@section('content')

    <div class="container">
        <h1>Termine</h1>
        @if(count($appointments))
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Datum</th>
                    <th>Titel</th>
                    <th>Ort</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    <tr class="clickable-row" data-href="{{ action('AppointmentController@show', [$appointment->id]) }}">
                        @if($appointment->end_date)
                            <td>{!! $appointment->date->format('d.m.Y') !!} - {!! $appointment->end_date->format('d.m.Y') !!}</td>
                        @else
                            <td>{!! $appointment->date->format('d.m.Y') !!}
                        @endif
                        <td>{!! $appointment->title !!}</td>
                        <td>{!! $appointment->addressStr() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Noch keine Termine vorhanden!
        @endif
    </div>

    {!! $appointments->render() !!}

    <hr>

@endsection