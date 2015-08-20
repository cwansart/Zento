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
                    $('#appointments_dialog').attr('action', '{!! action('AppointmentController@store') !!}');
                    $('#appointments_dialog').attr('method', 'POST');
                    $('#modal_title').html('Termin erstellen');
                    clear();
                    d = new Date(date);
                    $('#date').val(d.toLocaleFormat('%d.%m.%Y'));
                    $('#end_date').val(d.toLocaleFormat('%d.%m.%Y'));
                    $('#createModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    $('#appointments_dialog').attr('action', '{!! action('AppointmentController@update') !!}');
                    $('#appointments_dialog').attr('method', 'PUT');
                    $('#modal_title').html('Termin bearbeiten');
                    clear();
                    d_start = new Date(event.start);
                    d_end = new Date(event.end);
                    $('#title').val(event.title);
                    $('#description').val(event.description);
                    $('#date').val(d_start.toLocaleFormat('%d.%m.%Y'));
                    $('#end_date').val(d_end.toLocaleFormat('%d.%m.%Y'));
                    $('#holeDay').prop("checked", event.allDay);
                    showTime();
                    console.log(event.allDay);
                    if (!event.allDay) {
                        console.log(d_end.toLocaleFormat('%H:%M'));
                        $('[name = time]').val(d_start.toLocaleFormat('%H:%M'));
                        $('[name = end_time]').val(d_end.toLocaleFormat('%H:%M'));
                    }
                    $('#createModal').modal('show');
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

            showTime();
        });

        function clear() {
            $('#title').val(null);
            $('#description').val(null);
            $('#date').val(null);
            $('#end_date').val(null);
            $('#time').val(null);
            $('#end_time').val(null);
            $('#holeDay').val(null);
        }

        function showTime() {
            if ($('#holeDay').is(':checked')) {
                $(".timepicker").addClass('hidden');
                $(".timepicker input").prop('required', false);
            } else {
                $(".timepicker").removeClass('hidden');
                $(".timepicker input").prop('required', true);
            }
        }
    </script>

@endsection