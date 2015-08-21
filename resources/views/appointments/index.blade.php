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
            ____dateFormat = 'DD.MM.YYYY';
            ____timeFormat = 'HH:mm';

            $('#calendar').fullCalendar({
                // put your options and callbacks here

                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    $('#appointments_dialog').attr('action', '{!! action('AppointmentController@store') !!}');
                    $('[name=_method]').val('POST');
                    $('#modal_title').html('Termin erstellen');
                    clear();
                    var dateTime = date.format(____dateFormat+' ' +____timeFormat);
                    $('.timepicker').data().DateTimePicker.setDate(dateTime);
                    $('#end-date-group .timepicker').data().DateTimePicker.setDate(dateTime);
                    $('#createModal').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    console.log('allDay: ');
                    console.log(event.allDay);
                    if(event.allDay) {
                        event.end = event.start;
                    }

                    $('#appointments_dialog').attr('action', '{!! route('appointments.update', null) !!}/'+event.id);
                    $('[name=_method]').val('PUT');
                    $('#modal_title').html('Termin bearbeiten');
                    clear();

                    $('#title').val(event.title);
                    $('#description').val(event.description);

                    $('.timepicker').data().DateTimePicker.setDate(event.start.format(____dateFormat+' ' +____timeFormat));
                    $('#end-date-group .timepicker').data().DateTimePicker.setDate(event.end.format(____dateFormat+' ' +____timeFormat));

                    $('#holeDay').prop("checked", event.allDay);
                    showTime();
                    $('#createModal').modal('show');
                },

                timeFormat: ____timeFormat
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('.timepicker').datetimepicker({
                language: 'de',
                format: ____dateFormat+' ' +____timeFormat,
                useCurrent: false,
                sideBySide: true
            });

            showTime();
        });

        function clear() {
            $('#appointments_dialog')[0].reset();
            $('.timepicker').data().DateTimePicker.setDate()
        }

        function showTime() {
            if ($('#holeDay').is(':checked')) {
                $("#end-date-group").addClass('invisible');
                $("#end-date-group input").prop('required', false)
                $('.timepicker').data().DateTimePicker.format = ____dateFormat;
                $('.timepicker').data().DateTimePicker.setDate($('.timepicker').data().DateTimePicker.getDate());
            } else {
                $("#end-date-group").removeClass('invisible');
                $("#end-date-group input").prop('required', true);
                $('.timepicker').data().DateTimePicker.format = ____dateFormat+' ' +____timeFormat;
                $('.timepicker').data().DateTimePicker.setDate($('.timepicker').data().DateTimePicker.getDate());
            }
        }
    </script>

@endsection