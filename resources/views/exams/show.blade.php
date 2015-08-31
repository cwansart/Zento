@extends('main')

@section('title', 'Prüflinge vom '.$exam->date)

@section('content')

    <div class="container">
        <h1>Prüflinge vom {!! $exam->date !!}</h1>
        <table class="table table-hover table-exam">
            <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Ergebnis</th>
                @if(Auth::user()->is_admin)
                    <th>Aktion</th>
                @endif
            </tr>
            </thead>
            <tbody id="userslist">
            @foreach($users as $user)
                <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->id]) }}">
                    <td>{!! $user->firstname !!}</td>
                    <td>{!! $user->lastname !!}</td>
                    <td>{!! $user->pivot->result !!}</td>
                    @if(Auth::user()->is_admin)
                        <td>
                            <a href="{!! action('ExamController@removeUser', [$exam->id, $user->id]) !!}" class="delete delete-confirm" title="Prüfling entfernen" data-toggle="tooltip" data-placement="right"></a>
                        </td>
                    @endif
                </tr>
            @endforeach
            @if(Auth::user()->is_admin)
                {!! Form::open(array('id' => 'add-exam-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'action' => array('ExamController@addUser', $exam->id))) !!}
                <tr>
                    <td colspan="2">

                        <select class="form-control select2" id="userid" name="userid">
                            <option value="-1">Benutzer hinzufügen...</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" id="result" name="result" disabled>
                            <option value="-1">Note auswählen...</option>
                            @foreach($results as $id => $name)
                                <option value="{!! $id !!}">{!! $name !!}</option>
                            @endforeach
                        </select>

                    </td>
                </tr>
                {!! Form::close() !!}
            @endif
            </tbody>
        </table>



        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}
    </div>

    {{--
    {!! $seminarUsers->render() !!}
    --}}

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                language: 'de',
                ajax: {
                    url: '{!! action('ExamController@getUnregisteredUsers', [$exam->id]) !!}',
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
                $('#result').prop('disabled', false).focus();
            });

            $('#result').on('change', function(e) {
                $('#add-exam-form').submit();
            });

            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection