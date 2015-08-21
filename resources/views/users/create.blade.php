@extends('main')

@section('title', 'Benutzer anlegen')

@section('content')

    <div class="container">
        <h1>Benutzer anlegen</h1>
        @include('users.createFormContainer')
    </div>

@endsection