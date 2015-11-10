@extends('main')

@section('title', 'Termine')

@section('content')
    <div class="container">
        <h1>{!! \Zento\Appointment::$months[$month - 1]." ".$year !!}</h1>


        <a class="btn btn-primary pull-right" id="show-create-dialog-button">Termin erstellen</a>
        <a class="btn btn-default pull-right btn-space-right btn-no-border" href="{!! action('AppointmentController@notifyTrainer') !!}"
           data-toggle="tooltip"  data-placement="bottom" title="Trainer werden über ausstehende Termine ohne eingetragenen Trainer benachrichtigt">Benachrichtigung senden</a>
        <br>

        @if($month > 1)
            <a href="{{ URL::route('appointments.index', ['year' => $year, 'month' => $month - 1]) }}">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        @else
            <a href="{{ URL::route('appointments.index', ['year' => $year - 1, 'month' => 12]) }}">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        @endif
        @if($month < 12)
            <a href="{{ URL::route('appointments.index', ['year' => $year, 'month' => $month + 1]) }}">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        @else
            <a href="{{ URL::route('appointments.index', ['year' => $year + 1, 'month' => 1]) }}">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        @endif

        <table class="zento-calendar">
            <tr>
                <!-- Table headers -->
                @foreach(\Zento\Appointment::$weekdays as $weekday)
                    <th class="zc-header">{!! $weekday !!}</th>
                @endforeach
            </tr>
            @for($i = 0; $i < count($calendar_days); $i++)
                @if($i % 7 == 0)
                    <tr>
                @endif
                <td class="{!! $calendar_days[$i]["class"] !!}"
                    data-date="{!! $calendar_days[$i]["data-date"] !!}">
                    {!! $calendar_days[$i]["num"] !!}
                    @foreach($calendar_days[$i]["appointments"] as $appointment)
                        <div class="{!! $appointment["class"] !!}" data-id="{!! $appointment["id"] !!}">
                            <span class="{!! $appointment["trainer"] !!}"></span>{{ $appointment["title"] }}
                        </div>
                    @endforeach
                    @foreach($calendar_days[$i]["birthdays"] as $birthday)
                        <div class="zc-event-birthday"
                             data-href="{!! action('UserController@show', [$birthday["id"]]) !!}">
                            {!! $birthday["name"]." (".strval($calendar_days[$i]["year"] - $birthday["year"]).")" !!}
                        </div>
                    @endforeach
                </td>
                @if(($i + 1) % 7 == 0)
                    </tr>
                @endif
            @endfor
        </table>

        <table>
            <tr>
                <td width="120px"><div class="zc-event zc-event-training">Training</div></td>
                <td width="120px"><div class="zc-event zc-event-training"><span class="glyphicon glyphicon-question-sign zc-red"></span>Kein Trainer</div></td>
                <td width="120px"><div class="zc-event zc-event-seminar">Lehrgang</div></td>
                <td width="120px"><div class="zc-event zc-event-exam">Prüfung</div></td>
                <td width="120px"><div class="zc-event">Allgemein</div></td>
                <td width="120px"><div class="zc-event zc-event-birthday">Geburtstag</div></td>
            </tr>
        </table>
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

    <div class="popover fade bottom" role="tooltip" id="appointment-tooltip">
        <div class="arrow"></div>
        <div class="popover-content">
            <div class="title"></div>
            <div class="text-info">
                <span class="start"></span>
                –
                <span class="end"></span>
            </div>
            <div class="description"></div>
            <div class="trainer hidden">Trainer (Priorität): <ul class="actual-trainer"></ul></div>
        </div>
        <div class="popover-controls">
            <div style="margin: 0; padding: 0; line-height: 22px;">
                <a href="#" class="edit" title="Termin bearbeiten" data-toggle="tooltip" data-placement="right"></a>
                <a href="#" class="delete delete-confirm" title="Termin löschen" data-toggle="tooltip" data-placement="right"></a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('#appointment-tooltip').click(function () {
                $('#appointment-tooltip').removeClass('in');
            });

            $('.zc-event, .zc-event-left, .zc-event-middle, .zc-event-right').click(function (event) {
                event.stopPropagation();
                var that = this;
                that.appointmentRoute = '{!! action('AppointmentController@show', null) !!}/' + event.target.getAttribute('data-id');

                // these two lines enable the "fade out" effect
                $('#appointment-tooltip').removeClass('in');
                window.setTimeout(function () {
                    $.getJSON(that.appointmentRoute, function (appointment) {
                        var editRoute = ('{!! action('AppointmentController@edit') !!}').replace('%7Bappointments%7D', event.target.getAttribute('data-id'));
                        var destroyRoute = ('{!! action('AppointmentController@destroy') !!}').replace('%7Bappointments%7D', event.target.getAttribute('data-id'));
                        $('#appointment-tooltip .popover-controls .edit').attr('href', editRoute);
                        $('#appointment-tooltip .popover-controls .delete').attr('href', destroyRoute);

                        $('#appointment-tooltip .title').text(appointment.title);
                        $('#appointment-tooltip .description').text(appointment.description ? appointment.description : '');

                        var format = appointment.allDay ? 'dd.mm.yyyy' : 'dd.mm.yyyy HH:MM';
                        var pattern = /(\d{2})\.(\d{2})\.(\d{4}).?(\d{2})?\:?(\d{2})?/;
                        var start;
                        var end;
                        if (appointment.allDay) {
                            start = (new Date(appointment.start.replace(pattern, '$3-$2-$1'))).format(format);
                            end = (new Date(appointment.end.replace(pattern, '$3-$2-$1'))).format(format);
                        } else {
                            start = (new Date(appointment.start.replace(pattern, '$3-$2-$1T$4:$5:00'))).format(format);
                            end = (new Date(appointment.end.replace(pattern, '$3-$2-$1T$4:$5:00'))).format(format);
                        }

                        $('#appointment-tooltip .start').text(start);
                        $('#appointment-tooltip .end').text(end);

                        var trainerRoute = '{!! action('AppointmentController@getTrainer', null) !!}/' + event.target.getAttribute('data-id');
                        $.getJSON(trainerRoute, function (trainer) {
                            if (trainer.length) {
                                var trainerList = "";
                                for (i = 0; i < trainer.length; i++) {
                                    var prio = ["Nicht möglich", "Niedrig", "Normal", "Hoch"];
                                    trainerList += "<li>" + trainer[i].firstname + " " + trainer[i].lastname;
                                    trainerList += " (" + prio[trainer[i].pivot.priority] + ")"+ "</li>";
                                }
                                $('#appointment-tooltip .actual-trainer').html(trainerList);
                                $('#appointment-tooltip .trainer').removeClass('hidden');
                            } else {
                                $('#appointment-tooltip .trainer').addClass('hidden');
                            }
                        });

                        var tooltipCenter = $('#appointment-tooltip').width() / 2;
                        $('#appointment-tooltip').addClass('in').css('top', event.pageY).css('left', event.pageX - tooltipCenter);
                    });
                }, 50);
            });

            $('.zc-event-birthday').click(function (event) {
                event.stopPropagation();
                window.document.location = $(this).data("href");
            });

            $('.zc-day').click(function (event) {
                $('.form-horizontal')[0].reset();
                $('#start-picker').data().DateTimePicker.format = 'DD.MM.YYYY hh:MM';
                $('#end-picker').data().DateTimePicker.format = 'DD.MM.YYYY hh:MM';
                $('#start-picker').data().DateTimePicker.setDate(event.target.getAttribute('data-date'));
                $('#end-picker').data().DateTimePicker.setDate(event.target.getAttribute('data-date'));
                $('#appointment-create-dialog').modal('show');

                $('[data-toggle="tooltip"]').tooltip()
            });

            $('#show-create-dialog-button').on('click', function () {
                $('.form-horizontal')[0].reset();
                $('#appointment-create-dialog').modal('show');
            });
        });
    </script>

@endsection