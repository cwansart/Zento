@extends('main')

@section('title', 'Benutzerliste')

@section('content')
    <div class="container">
        <h1>Benutzerliste</h1>
        @if(count($users))
        <table class="table table-hover table-user">
            <thead>
            <tr>
                <th>Vorname <a href="{!! action('UserController@index', ['orderBy' => 'firstname:' . ($sortBy == 'firstname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="{!! action('UserController@index', ['orderBy' => 'lastname:' . ($sortBy == 'lastname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Prüfungsergebnis</th>
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
                    @if(Auth::user()->is_admin)
                        <td>
                            {!! Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                            {!! Html::linkAction('UserController@edit', '', [$user->id], ['class' => 'edit', 'title' => 'Benutzer bearbeiten', 'data-toggle' => 'tooltip', 'data-placement' => 'right']) !!}
                            {!! Html::linkAction('UserController@changePassword', '', [$user->id], ['class' => 'change-password', 'title' => 'Passwort ändern', 'data-toggle' => 'tooltip', 'data-placement' => 'right']) !!}
                            @if(Auth::user()->id != $user->id)
                                {!! Form::submit('', ['class' => 'delete', 'title' => 'Benutzer löschen', 'data-toggle' => 'tooltip', 'data-placement' => 'right']) !!}
                            @endif
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            Noch keine Benutzer vorhanden!
        @endif
    </div>

    {!! $users->render() !!}

    @if(Auth::user()->is_admin)
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Benutzer erstellen</button>

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
        })
    </script>

@endsection