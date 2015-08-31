@extends('main')

@section('title', 'Teilnehmer „'.$seminar->title.'“')

@section('content')

    <div class="container">
        <h1>Teilnehmer des Seminars „{!! $seminar->title !!}“</h1>
        <table class="table table-hover table-seminar">
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
                            <a href="{!! action('SeminarController@destroy', [$seminar->id, $user->id]) !!}" class="delete delete-confirm" title="Teilnehmer entfernen" data-toggle="tooltip" data-placement="right"></a>
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
                    url: '{!! action('SeminarController@getUnregisteredUsers', [$seminar->id]) !!}',
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
                    //var birthday = new Date(user.birthday.split(' ')[0]);
                    return '<div class="clearfix"><div>'+user.firstname+' '+ user.lastname +', '+ user.email +' ('+ user.birthday +')</div></div>';
                },
                templateSelection: function(user) {
                    if(user.firstname || user.lastname) {
                        var name = user.firstname + ' ' + user.lastname;
                    }
                    return name || user.text;
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

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endsection