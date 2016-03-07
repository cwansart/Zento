<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
</head>
<body>
<div class="zc-mail">
    <p>Hallo {!! $user->firstname.' '.$user->lastname !!},</p>
    <p>
        du wolltest für den folgenden Termin erinnert werden:
    </p>
    <p>{!! $appointment->title !!}</p>
    <p>
        @if($appointment->allDay)
            {!! \Carbon\Carbon::parse($appointment->start)->format('d.m.Y') !!} - {!! \Carbon\Carbon::parse($appointment->end)->format('d.m.Y') !!}
        @else
            {!! \Carbon\Carbon::parse($appointment->start)->format('d.m.Y H:i') !!} - {!! \Carbon\Carbon::parse($appointment->end)->format('d.m.Y H:i') !!}
        @endif
    </p>
    @if(!is_null($appointment->description))
        <p>{!! $appointment->description !!}</p>
    @endif
    <p>Deine Priorität: {!! $priority !!}</p>
    <p>
        Dies ist eine automatisch generierte E-Mail, erstellt mit Hilfe von <a href="{!! URL::to('/') !!}">Zento</a>.
        Bitte nicht antworten.
    </p>
</div>
</body>
</html>