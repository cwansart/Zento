@extends('main')

@section('title', 'Benutzerdetails'.' '.$user->firstname.' '.$user->lastname)

@section('content')

    <br>
    <div class="container">
        <h1>Benutzerdetails</h1>
        <table class="table table-hover">
            <tr>
                <td>Vorname:</td>
                <td>{!! $user->firstname !!}</td>
            </tr>
            <tr>
                <td>Nachname:</td>
                <td>{!! $user->lastname !!}</td>
            </tr>
            <tr>
                <td>Adresse:</td>
                <td>{!! $user->addressStr() !!}</td>
            </tr>
            <tr>
                <td>E-Mail:</td>
                <td>{!! $user->email !!}</td>
            </tr>
            <tr>
                <td>Geburtstag:</td>
                <td>{!! $user->birthday->format('d.m.Y') !!}</td>
            </tr>
            <tr>
                <td>Eintrittsdatum:</td>
                <td>{!! $user->entry_date->format('d.m.Y') !!}</td>
            </tr>
            @if($user->group)
                <tr>
                    <td>Gruppe:</td>
                    <td>{!! $user->group->name !!}</td>
                </tr>
            @endif
            <tr>
                <td>Benutzerkonto aktiv:</td>
                <td>{!! $user->active ? 'Ja' : 'Nein' !!}</td>
            </tr>
        </table>

        <h3>Seminarteilnahmen</h3>
        @if(count($seminars))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Titel</th>
                        <th>Ort</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seminars as $seminar)
                        <tr class="clickable-row" data-href="{{ action('SeminarController@show', [$seminar->id]) }}">
                            <td>{!! $seminar->date->format('d.m.Y') !!}</td>
                            <td>{!! $seminar->title !!}</td>
                            <td>{!! $seminar->addressStr() !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Keine Seminarteilnahmen vorhanden
        @endif

        <h3>Prüfungsteilnahmen</h3>
        @if(count($exams))
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Ergebnis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="clickable-row" data-href="{{ action('ExamController@show', [$exam->id]) }}">
                            <td>{!! $exam->getFormattedDate() !!}</td>
                            <td>{!! $exam->pivot->result !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Keine Prüfungen vorhanden</p>
        @endif

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

    </div>

@endsection