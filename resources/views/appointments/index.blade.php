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

                dayClick: function (date, jsEvent, view) {
                    $('#myModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    window.location.href = '{!! url('appointments') !!}/'  + event.id;
                },

                timeFormat: 'HH:mm'
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.datetimepicker').datetimepicker({
                language: 'de',
                format: 'DD.mm.yyyy hh:mm'
            });
        });
    </script>

@endsection