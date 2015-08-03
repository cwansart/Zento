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
                <th>Vorname</th>
                <th>Nachname</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->id]) }}">
                    <td>{!! $user->firstname !!}</td>
                    <td>{!! $user->lastname !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            Noch keine Benutzer vorhanden!
        @endif
    </div>

    {!! $users->render() !!}

    {{--
        Wir sollten hier noch überlegen, ob wir den Dialog nicht mittels jQuery einblenden lassen sollten als modaler Dialog.
        {!! Form::button('Benutzer hinzufügen', array('class' => 'btn btn-primary', 'id' => 'users_index_create_button')) !!}
     --}}
    
    <hr>

    @if(Auth::user()->is_admin)
    @include('users.create')
    @endif

@endsection