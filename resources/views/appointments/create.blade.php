@extends('main')

@section('title', 'Termin anlegen')

@section('content')

    <div class="container">
        <h1>Termin anlegen</h1>
        @include('appointments.createFormContainer')
    </div>

@endsection