@extends('main')

@section('title', 'Seminarübersicht')

@section('content')

    <div class="container">
        <h1>Seminarübersicht</h1>

        @if(Auth::user()->is_admin)
            <button type="button" class="btn btn-primary  pull-right" data-toggle="modal" data-target="#myModal">Seminar erstellen</button>
        @endif

        @include('seminars._filter')

        @if(count($seminars))

            <table class="table table-hover table-seminar">
                <thead>
                <tr>
                    <th>Datum <a href="{!! action('SeminarController@index', ['orderBy' => 'date:' . ($sortBy == 'date:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'date:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                    <th>Titel <a href="{!! action('SeminarController@index', ['orderBy' => 'title:' . ($sortBy == 'title:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'title:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
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
                                <a href="{!! action('SeminarController@edit', $seminar->id) !!}" class="edit" title="Seminar bearbeiten" data-toggle="tooltip" data-placement="right"></a>
                                <a href="{!! action('SeminarController@destroy', $seminar->id) !!}" class="delete delete-confirm" title="Seminar löschen" data-toggle="tooltip" data-placement="right"></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            @if($filterSearch == '')
                Noch keine Seminare vorhanden!
            @else
                Keine Seminare gefunden!
            @endif
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
        });

        $(document).ready(function() {
            $('#set-filter').click(function () {
                filter();
            });

            $('#filterS').keypress(function (e) {
                if (e.which == 13) {
                    filter();
                    return false;    //<---- Add this line
                }
            });
        });

        function filter() {
            var search = "<?php echo $filterSearch; ?>";
            if($('#filterS').val() != "" || ($('#filterS').val() == "" && search != "")) {
                window.location.href = '{!! action('SeminarController@index') !!}?' + ($('#filterS').val() != '' ? 'q=' + $('#filterS').val() : '');
            }
        }
    </script>

@endsection