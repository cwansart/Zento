@extends('main')

@section('title', 'Termine')

@section('content')

    <br>

    <div class="container">

        <div id='calendar'></div>

    </div>

    <hr>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                // put your options and callbacks here
                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function(date, jsEvent, view) {
                    window.location.href = '/appointments/' + date._d.toLocaleDateString();
                }
            });
            $('#calendar').fullCalendar( 'rerenderEvents' );
        });
    </script>

@endsection