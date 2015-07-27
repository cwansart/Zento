@extends('main')

@section('title', 'Profil bearbeiten')

@section('content')

    <div class="container">
        <h1>Profil bearbeiten</h1>
        <p>Hallo {!! $user->firstname !!} {!! $user->lastname !!}!</p>

        {{--
            TODO: Passwort ändern Dialog
        --}}
    </div>

    <hr>

@endsection