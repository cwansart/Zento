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
                language: 'de',
                format: ____dateFormat+' ' +____timeFormat
            });

            showTime();
        });

        function clear() {
            $('#appointments_dialog')[0].reset();
        }

        function showTime() {
            if ($('#holeDay').is(':checked')) {
                $("#end-date-group").addClass('invisible');
                $("#end-date-group input").prop('required', false);
            } else {
                $("#end-date-group").removeClass('invisible');
                $("#end-date-group input").prop('required', true);
            }
        }
    </script>

@endsection