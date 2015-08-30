@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
        <h1>Seminarübersicht</h1>
        @if(count($seminars))

            <table class="table table-hover table-seminar">
                <thead>
                <tr>
                    <th>Datum</th>
                    <th>Titel</th>
                    <th>Ort</th>
                    <th>Teilnehmer</th>
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
                        <td>{!! $seminar->users->count() !!}</td>
                        @if(Auth::user()->is_admin)
                            <td>
                                <a href="{!! action('SeminarController@edit', $seminar->id) !!}" class="edit" title="Benutzer bearbeiten" data-toggle="tooltip" data-placement="right"></a>
                                <a href="{!! action('SeminarController@destroy', $seminar->id) !!}" class="delete delete-confirm"></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            Noch keine Seminare vorhanden!
        @endif
        @if(Auth::user()->is_admin)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Seminar erstellen</button>
        @endif

        {!! $seminars->render() !!}
    </div>


    @if(Auth::user()->is_admin)
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seminar erstellen</h4>
                    </div>
                    <div class="modal-body">
                        @include('seminars.createFormContainer')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endsection