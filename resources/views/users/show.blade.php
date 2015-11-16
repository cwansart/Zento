@extends('main')

@section('title', 'Benutzerdetails'.' von '.$user->firstname.' '.$user->lastname)

@section('content')

    <div class="container">
        <h1>{!! $user->firstname !!} {!! $user->lastname !!}</h1>
        <table class="table table-2cols">
            <tr>
                <td>Adresse:</td>
                <td>{!! $user->isTrainer() !!}</td>
            </tr>
            <tr>
                <td>E-Mail:</td>
                <td>{!! $user->email !!}</td>
            </tr>
            <tr>
                <td>Geburtstag:</td>
                <td>{!! $user->birthday !!}</td>
            </tr>
            <tr>
                <td>Eintrittsdatum:</td>
                <td>{!! $user->entry_date !!}</td>
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

		<hr>

        <h3>Prüfungsteilnahmen</h3>
        @if(count($exams))
            <table class="table table-hover table-2cols">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Ergebnis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="clickable-row" data-href="{{ action('ExamController@show', [$exam->id]) }}">
                            <td>{!! $exam->date !!}</td>
                            <td>{!! $exam->pivot->result !!}</td>
                            @if(is_array($user->latestResultColor($exam->pivot->result)))
                                <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($exam->pivot->result)[0] !!}"><div class="zento-result-color-second" style="background: {!! $user->latestResultColor($exam->pivot->result)[1] !!}"></div></div></td>
                            @else
                                <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($exam->pivot->result) !!}"></div></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Keine Prüfungen vorhanden</p>
        @endif

        <hr>

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
                        <td>{!! $seminar->date !!}</td>
                        <td>{!! $seminar->title !!}</td>
                        <td>{!! $seminar->addressStr() !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Keine Seminarteilnahmen vorhanden
        @endif

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

    </div>

@endsection