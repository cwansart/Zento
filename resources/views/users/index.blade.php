@extends('main')

@section('title', 'Benutzerliste')

@section('content')

    <div class="container">
        <ul>
            @foreach($users as $user)

                <li>{!! $user->firstname !!}, {!! $user->lastname !!}</li>

            @endforeach
        </ul>
    </div>

    {!! $users->render() !!}

@endsection