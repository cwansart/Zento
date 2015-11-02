@extends('main')

@section('title', 'Benutzerliste')

@section('content')
    <div class="container">
        <h1>Benutzerliste</h1>

		@if(Auth::user()->is_admin)
            <button type="button" class="btn btn-primary pull-right btn-create" data-toggle="modal" data-target="#myModal">Benutzer erstellen</button>
        @endif

        @include('users._filter')

        @if(count($users))
            <table class="table table-hover table-user">
                <thead>
                <tr>
                    <th>Vorname <a href="{!! action('UserController@index', ['orderBy' => 'firstname:' . ($sortBy == 'firstname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                    <th>Nachname <a href="{!! action('UserController@index', ['orderBy' => 'lastname:' . ($sortBy == 'lastname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes' : 'glyphicon glyphicon-sort-by-attributes-alt' !!}" aria-hidden="true"></span></a></th>
                    <th>Graduierung</th>
                    <th></th>
                    @if(Auth::user()->is_admin)
                        <th>Aktion</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->id]) }}">
                        <td>{!! $user->firstname !!}</td>
                        <td>{!! $user->lastname !!}</td>
                        <td>{!! $user->latestResult() !!}</td>
                        @if(is_array($user->latestResultColor($user->latestResult())))
                            <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($user->latestResult())[0] !!}"><div class="zento-result-color-second" style="background: {!! $user->latestResultColor($user->latestResult())[1] !!}"></div></div></td>
                        @else
                            <td><div class="zento-result-color-first" style="background: {!! $user->latestResultColor($user->latestResult()) !!}"></div></td>
                        @endif
                        @if(Auth::user()->is_admin)
                            <td>
                                <a href="{!! action('UserController@edit', $user->id) !!}" class="edit" title="Benutzer bearbeiten" data-toggle="tooltip" data-placement="right"></a>
                                <a href="{!! action('UserController@changePassword', $user->id) !!}" class="change-password" title="Passwort ändern" data-toggle="tooltip" data-placement="right"></a>
                                <a href="{!! action('UserController@destroy', $user->id) !!}" class="delete delete-confirm" title="Benutzer löschen" data-toggle="tooltip" data-placement="right"></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            @if($filterSearch == '')
                    Noch keine Benutzer vorhanden!
                @else
                    Keine Benutzer gefunden!
                @endif
        @endif



        {!! $users->render() !!}
    </div>

    @if(Auth::user()->is_admin)
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Benutzer erstellen</h4>
                    </div>
                    <div class="modal-body">
                        @include('users.createFormContainer')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>
        @if(count($errors))
            <script>
                $(function() {
                    $('#myModal').modal('show');
                });
            </script>
        @endif
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
            if($('#filterG option:selected').val() != '0' || $('#filterA option:selected').val() != '-1' || $('#filterS').val() != "" || ($('#filterS').val() == "" && search != "")) {
                window.location.href = '{!! action('UserController@index') !!}?' + ($('#filterG option:selected').val() != '0' ? 'g=' + $('#filterG option:selected').val() + '&' : '') + ($('#filterA option:selected').val() != '-1' ? 'a=' + $('#filterA option:selected').val() + '&' : '') + ($('#filterS').val() != '' ? 'q=' + $('#filterS').val() : '');
            }
        }
    </script>

@endsection