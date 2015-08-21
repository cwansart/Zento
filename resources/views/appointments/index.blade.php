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
            var ____dateFormat = 'DD.MM.YYYY';
            var ____timeFormat = 'HH:mm';

            $('#calendar').fullCalendar({
                // put your options and callbacks here

                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    $('#appointments_dialog').attr('action', '{!! action('AppointmentController@store') !!}');
                    $('[name=_method]').val('POST');
                    $('#modal_title').html('Termin erstellen');
                    clear();
                    d = new Date(date);
                    $('#date').val(d.format(____dateFormat));
                    $('#end_date').val(d.format(____dateFormat));
                    $('#createModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    $('#appointments_dialog').attr('action', '{!! route('appointments.update', null) !!}/'+event.id);
                    $('[name=_method]').val('PUT');
                    $('#modal_title').html('Termin bearbeiten');
                    clear();

                    $('#title').val(event.title);
                    $('#description').val(event.description);
                    $('#date').val(event.start.format(____dateFormat));
                    $('#end_date').val(event.end.format(____dateFormat));
                    $('#holeDay').prop("checked", event.allDay);
                    showTime();
                    if (!event.allDay) {
                        $('[name = time]').val(event.start.format(____timeFormat));
                        $('[name = end_time]').val(event.end.format(____timeFormat));
                    }
                    $('#createModal').modal('show');
                },

                timeFormat: ____timeFormat
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.timepicker').datetimepicker({
                maskInput: false,
                language: 'de',
                pickDate: false,
                format: ____timeFormat
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