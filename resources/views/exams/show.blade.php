@extends('main')

@section('title', 'Prüflinge vom '.$exam->getFormattedDate())

@section('content')

    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    Es gab ein paar Probleme.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <h1>Prüflinge vom {!! $exam->getFormattedDate() !!}</h1>
        @if(count($users))
                {!! Form::open(array('id' => 'add-exam-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'route' => array('exams.update', $exam->id))) !!}
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Ergebnis</th>
                </tr>
                </thead>
                <tbody id="userslist">
                @foreach($users as $user)
                    <tr class="clickable-row" data-href="{{ action('UserController@show', [$user->id]) }}">
                        <td>{!! $user->firstname !!}</td>
                        <td>{!! $user->lastname !!}</td>
                        <td>{!! $user->pivot->result !!}</td>
                    </tr>
                @endforeach
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

                </tbody>
            </table>
                {!! Form::close() !!}
        @else
            <p>Noch keine Ergebnisse eingetragen!</p>
        @endif

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
                   url: '{!! action('ExamController@getUnregisterdUsers', [$exam->id]) !!}',
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
                $('#result').prop('disabled', false).focus();
            });

            $('#result').on('change', function(e) {
                $('#add-exam-form').submit();
            });
        });
    </script>

@endsection