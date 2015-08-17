@extends('main')

@section('title', 'Termine')

@section('content')

    <br>

    <div class="container">
        <div id='calendar'></div>
        @include('appointments.create')
        @include('appointments.show')
    </div>

    <hr>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                // put your options and callbacks here

                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    d = new Date(date);
                    $('#date').val(d.toLocaleFormat('%d.%m.%Y'));
                    $('#end_date').val(d.toLocaleFormat('%d.%m.%Y'));
                    $('#createModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    d_start = new Date(event.start);
                    d_end = new Date(event.end);
                    $('#title').val(event.title);
                    $('#date').val(d_start.toLocaleFormat('%d.%m.%Y'));
                    $('#end_date').val(d_end.toLocaleFormat('%d.%m.%Y'));
                    $('#showModal').modal('show');
                },

                timeFormat: 'HH:mm'
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.timepicker').datetimepicker({
                maskInput: false,
                language: 'de',
                pickDate: false,
                format: 'HH:mm'
            });

            if ($('#holeDay').is(':checked')) {
                $(".timepicker").addClass('hidden');
            } else {
                $(".timepicker").removeClass('hidden');
            }
        });
    </script>

@endsection