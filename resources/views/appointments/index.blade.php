@extends('main')

@section('title', 'Termine')

@section('content')

    <br>

    <div class="container">
        <div id='calendar'></div>
        @include('appointments.create')
    </div>

    <hr>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                // put your options and callbacks here

                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function(date, jsEvent, view) {
                    window.location.href = '/appointments/' + date._d.toLocaleDateString();
                },

                eventClick: function(event, jsEvent, view) {
                    window.location.href = '/appointments/' + event.id;
                },

                timeFormat: 'HH:mm'
            });
            $('#calendar').fullCalendar( 'rerenderEvents' );
        });
    </script>

@endsection