@extends('main')

@section('title', 'Benutzerliste')

@section('content')

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <h1>Benutzerliste</h1>
        @if(count($users))
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Vorname <a href="{!! action('UserController@index', ['orderBy' => 'firstname:' . ($sortBy == 'firstname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'firstname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
                <th>Nachname <a href="{!! action('UserController@index', ['orderBy' => 'lastname:' . ($sortBy == 'lastname:ASC' ? 'DESC' : 'ASC')]) !!}"><span class="glyphicon {!! $sortBy == 'lastname:ASC' ? 'glyphicon glyphicon-sort-by-attributes-alt' : 'glyphicon glyphicon-sort-by-attributes' !!}" aria-hidden="true"></span></a></th>
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
                    @if(Auth::user()->is_admin)
                        <td>
                            {!! Form::open(['action' => ['UserController@destroy', $user->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                            {!! Form::submit('Löschen', ['class' => 'btn btn-danger btn-sm']) !!}
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