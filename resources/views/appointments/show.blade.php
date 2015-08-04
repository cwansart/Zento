@extends('main')

@section('title', 'Termine '.$date)

@section('content')
    <br>
    <div class="container">
        <h1>Termine {!! $date !!}</h1>
        @if(count($appointments))
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Titel</th>
                    <th>Von</th>
                    <th>Bis</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr class="clickable-row" data-href="{{ action('AppointmentController@showEvent', [$appointment->id]) }}">
                            <td>{!! $appointment->title !!}</td>
                            @if($appointment->all_day)
                                <td>{!! $appointment->date->format('d.m.y') !!}</td>
                            @else
                                <td>{!! $appointment->date->format('d.m.y, H:i') !!}</td>
                            @endif

                            @if($appointment->end_date)
                                @if($appointment->all_day)
                                    <td>{!! $appointment->end_date->format('d.m.y') !!}</td>
                                @else
                                    <td>{!! $appointment->end_date->format('d.m.y, H:i') !!}</td>
                                @endif
                            @else
                                <td> - </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Keine Termine vorhanden.</p>
        @endif

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

    </div>


@endsection