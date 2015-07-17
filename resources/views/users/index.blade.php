@extends('main')

@section('title', 'Benutzerliste')

@section('content')

    <ul>
    @foreach($users as $user)

        <li>{!! $user->firstname !!}, {!! $user->lastname !!}</li>

    @endforeach
    </ul>

@endsection