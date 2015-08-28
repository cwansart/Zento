@extends('main')

@section('title', 'Termin '.$appointment->title)

@section('content')

    <div class="container-fluid" id="appointment-show-dialog">
        <h1>Termin „{!! $appointment->title !!}” vom {!! $appointment->start !!}</h1>

        <table class="table table-2cols">
            @if(!empty($appointment->description))
            <tr>
                <td>Beschreibung:</td>
                <td>{!! $appointment->description !!}</td>
            </tr>
            @endif
            <tr>
                <td>Von:</td>
                <td>{!! $appointment->start !!}</td>
            </tr>
            <tr>
                <td>Bis:</td>
                <td>{!! $appointment->end !!}</td>
            </tr>
            <tr>
                <td>Trainer:</td>
                <td>
                    @if($appointment->trainer)
                        {!! $appointment->trainer->firstname !!} {!! $appointment->trainer->lastname !!}
                    @else
                        Kein Trainer zugewiesen.
                    @endif
                </td>
            </tr>
        </table>

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
        <a href="{!! action('AppointmentController@edit', $appointment->id) !!}" class="btn btn-primary">Bearbeiten</a>
    </div>



@endsection