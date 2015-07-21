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

    {{--
        Wir sollten hier noch überlegen, ob wir den Dialog nicht mittels jQuery einblenden lassen sollten als modaler Dialog.
        {!! Form::button('Benutzer hinzufügen', array('class' => 'btn btn-primary', 'id' => 'users_index_create_button')) !!}
     --}}
    
    <hr>

    @include('users.create')

@endsection