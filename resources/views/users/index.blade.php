@extends('main')

@section('title', 'Benutzerliste')

@section('content')

    <div class="container">
        <h1>Benutzerliste</h1>
        @if(count($users))
        <table class="table table-hover">
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
                            {!! Html::linkAction('UserController@edit', 'Bearbeiten', [$user->id], ['class' => 'btn btn-primary btn-sm']) !!}
                            {!! Html::linkAction('UserController@changePassword', 'Passwort ändern', [$user->id], ['class' => 'btn btn-primary btn-sm']) !!}
                            @if(Auth::user()->id != $user->id)
                                {!! Form::submit('Löschen', ['class' => 'btn btn-danger btn-sm']) !!}
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
    @include('users.create')
    @endif

@endsection