@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
        <h1>Seminarübersicht</h1>
        @if(count($seminars))

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Titel</th>
                        <th>Ort</th>
                        @if(Auth::user()->is_admin)
                            <th>Aktion</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($seminars as $seminar)
                        <tr class="clickable-row" data-href="{{ action('SeminarController@show', [$seminar->id]) }}">
                            <td>{!! $seminar->date !!}</td>
                            <td>{!! $seminar->title !!}</td>
                            <td>{!! $seminar->addressStr() !!}</td>
                            @if(Auth::user()->is_admin)
                                <td>
                                    {!! Form::open(['action' => ['SeminarController@destroy', $seminar->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                                    {!! Html::linkAction('SeminarController@edit', 'Bearbeiten', [$seminar->id], ['class' => 'btn btn-primary btn-sm']) !!}
                                    {!! Form::submit('Löschen', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Noch keine Seminare vorhanden!
        @endif
    </div>

    {!! $seminars->render() !!}

    <hr>

    @if(Auth::user()->is_admin)
    @include('seminars.create')
    @endif

@endsection