@extends('main')

@section('title', 'Termine')

@section('content')
    <div class="container">
        <h1>{!! \Zento\Appointment::$months[$month - 1]." ".$year !!}</h1>
        <table class="zento-calendar">
            <tr>
                <!-- Table headers -->
                @foreach(\Zento\Appointment::$weekdays as $weekday)
                    <th class="zc-header">{!! $weekday !!}</th>
                @endforeach
            </tr>
            @for($day = 1; $day <= $total_days + $day_offset; $day++)
                @if(($day - 1)%7 == 0)
                    <tr>
                @endif

                @if($day_offset - $day + 1 > 0)
                    <td class="zc-day zc-other-month"
                        data-date="{!! \Carbon\Carbon::create($year, $month, 1)->addDay($day - $day_offset - 1)->format('d.m.Y') !!}">
                        {!! \Carbon\Carbon::create($year, $month, 1)->addDay($day - $day_offset - 1)->format('d') !!}</td>
                @elseif(\Carbon\Carbon::now()->day == ($day - $day_offset) &&
                        \Carbon\Carbon::now()->month == $month &&
                        \Carbon\Carbon::now()->year == $year)
                    <td class="zc-today zc-day"
                        data-date="{!! \Carbon\Carbon::create($year, $month, $day - $day_offset)->format('d.m.Y') !!}">
                        {!! $day - $day_offset !!}
                    <div class="zc-event">testevent</div></td>
                @else
                    <td class="zc-day"
                        data-date="{!! \Carbon\Carbon::create($year, $month, $day - $day_offset)->format('d.m.Y') !!}">
                        {!! $day - $day_offset !!}</td>
                @endif

                @if($day%7 == 0)
                    </tr>
                @endif
            @endfor
            @for($i = 1; $i <= (7 -(($total_days + $day_offset) % 7)); $i++)
                <td class="zc-day zc-other-month"
                    data-date="{!! \Carbon\Carbon::create($year, $month, $i)->addMonth(1)->format('d.m.Y') !!}">
                    {!! $i !!}</td>
            @endfor
        </table>

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
            <div class="trainer hidden">Trainer: <span class="actual-trainer"></span></div>
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

            $('.zc-day').click(function(event) {
                $('.form-horizontal')[0].reset();
                $('#start-picker').data().DateTimePicker.format = 'DD.MM.YYYY';
                $('#end-picker').data().DateTimePicker.format = 'DD.MM.YYYY';
                $('#start-picker').data().DateTimePicker.setDate(event.target.getAttribute('data-date'));
                $('#end-picker').data().DateTimePicker.setDate(event.target.getAttribute('data-date'));
                $('#appointment-create-dialog').modal('show');
            });

            $('#show-create-dialog-button').on('click', function() {
                $('.form-horizontal')[0].reset();
                $('#appointment-create-dialog').modal('show');
            });

            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>

@endsection