@extends('main')

@section('title', 'Benutzerdetails')

@section('content')

    <br>
    <div class="container">
        <table class="table table-hover">
            <tr>
                <td>Vorname:</td>
                <td>{!! $user->firstname !!}</td>
            </tr>
            <tr>
                <td>Nachname:</td>
                <td>{!! $user->lastname !!}</td>
            </tr>
            <tr>
                <td>Adresse:</td>
                <td>{!! $user->addressStr() !!}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{!! $user->email !!}</td>
            </tr>
            <tr>
                <td>Geburtstag:</td>
                <td>{!! $user->birthday->format('d.m.Y') !!}</td>
            </tr>
            <tr>
                <td>Eintrittsdatum:</td>
                <td>{!! $user->entry_date->format('d.m.Y') !!}</td>
            </tr>
            @if($user->group)
                <tr>
                    <td>Gruppe:</td>
                    <td>{!! $user->group->name !!}</td>
                </tr>
            @endif
            <tr>
                <td>Benutzerkonto aktiv:</td>
                <td>{!! $user->active ? 'Ja' : 'Nein' !!}</td>
            </tr>
        </table>

    </div>

@endsection