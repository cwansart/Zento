@extends('main')

@section('title', 'Teilnehmer „'.$seminar->title.'“')

@section('content')

    <div class="container">
        <h1>Teilnehmer des Seminars „{!! $seminar->title !!}“</h1>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
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
                            {!! Form::open(['action' => ['SeminarController@removeUser', $seminar->id, $user->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                            {!! Form::submit('Löschen', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach

            @if(Auth::user()->is_admin)
                <tr>
                    <td colspan="3">
                        {!! Form::open(array('id' => 'add-seminar-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'action' => array('SeminarController@addUser', $seminar->id))) !!}
                        <select class="form-control select2" id="userid" name="userid">
                            <option value="-1">Benutzer hinzufügen...</option>
                        </select>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endif
            </tbody>
        </table>

        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                language: 'de',
                ajax: {
                    url: '{!! action('SeminarController@getUnregisterdUsers', [$seminar->id]) !!}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        //console.log(params);
                        return {
                            q: params.term, // search term (in input field)
                            page: params.page
                        };
                    },
                    processResults: function(data, page) {
                        return {
                            results: data
                        }
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                minimumInputLength: 1,
                templateResult: function(user) {
                    if(user.loading) return user.text;
                    var birthday = new Date(user.birthday.split(' ')[0]);
                    return '<div class="clearfix"><div>'+user.firstname+' '+ user.lastname +', '+ user.email +' ('+ birthday.toLocaleDateString() +')</div></div>';
                },
                templateSelection: function(user) {
                    return user.firstname || user.text;
                }
            });

            $('.select2').on('select2:select', function(e) {
                $('#add-seminar-form').submit();
            });
        });
    </script>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

@endsection