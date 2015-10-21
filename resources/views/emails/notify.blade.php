<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="zc-mail">
    <p>Hallo Zento-Nutzer,</p>
    <p>
        bitte sieh dir diese Termine an:
    </p>
    @if(count($appointments))
        <p>
            Termine ohne eingetragenen Trainer:
        </p>
        <ul>
            @foreach($appointments as $appointment)
                <li>
                    @if($appointment->allDay)
                        {!! $appointment->start !!} - {!! $appointment->end !!}
                    @else
                        {!! $appointment->start !!} - {!! $appointment->end !!}
                    @endif
                        <a href="{!! action('AppointmentController@edit', $appointment->id) !!}">{!! $appointment->title !!}</a>
                    @if(!is_null($appointment->description))
                        ({!! $appointment->description !!})
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    @if(count($appointments_prio))
        <p>
            Termine mit zu geringer Priorität des Trainers:
        </p>
        <ul>
            @foreach($appointments_prio as $appointment)
                <li>
                    @if($appointment->allDay)
                        {!! $appointment->start !!} - {!! $appointment->end !!}
                    @else
                        {!! $appointment->start !!} - {!! $appointment->end !!}
                    @endif
                        <a href="{!! action('AppointmentController@edit', $appointment->id) !!}">{!! $appointment->title !!}</a>
                    @if(!is_null($appointment->description))
                        ({!! $appointment->description !!})
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
    <p>
        Bitte trag dich sobald es geht ein.
    </p>
    <p>
        Dies ist eine auf Wunsch von {!! $sender->firstname !!} {!! $sender->lastname !!} generierte E-Mail, erstellt
        mit Hilfe von <a href="{!! URL::to('/') !!}">Zento</a>. Antworten auf diese Mail gehen direkt an
        {!! $sender->firstname !!} {!! $sender->lastname !!}.
    </p>
</div>
</body>
</html>