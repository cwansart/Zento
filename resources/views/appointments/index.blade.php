@extends('main')

@section('title', 'Termine')

@section('content')
    <div class="container">
        <div id='calendar'></div>

        <a class="btn btn-primary" id="show-create-dialog-button">Termin erstellen</a>
    </div>

    <div class="modal fade" id="appointment-create-dialog" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Termin erstellen</h4>
                </div>
                <div class="modal-body">
                    @include('appointments.createFormContainer')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#calendar').fullCalendar({
                lang: 'de',
                timeFormat: 'HH:MM',
                events: '{!! action('AppointmentController@index') !!}',

                dayClick: function (date, jsEvent, view) {
                    $('#start-picker').data().DateTimePicker.setDate(date);
                    $('#end-picker').data().DateTimePicker.setDate(date);
                    $('#appointment-create-dialog').modal('show');
                },

                eventClick: function (event, jsEvent, view) {
                    var showRoute = '{!! action('AppointmentController@show') !!}';
                    showRoute = showRoute.replace('%7Bappointments%7D', event.id);
                    window.location = showRoute;
                },
            });
            $('#calendar').fullCalendar('rerenderEvents');

            $('#show-create-dialog-button').on('click', function() {
                $('.form-horizontal')[0].reset();
                $('#appointment-create-dialog').modal('show');
            });
        });
    </script>

@endsection