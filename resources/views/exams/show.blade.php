@extends('main')

@section('title', 'Prüflinge '.$results->first()->exam->date->format('d.m.Y'))

@section('content')

    <div class="container">
        <h1>Prüflinge vom {!! $results->first()->exam->date->format('d.m.Y') !!}</h1>
        @if(count($results))
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Ergebnis</th>
                </tr>
                </thead>
                <tbody id="userslist">
                @foreach($results as $result)
                    <tr class="clickable-row" data-href="{{ action('UserController@show', [$result->user->id]) }}">
                        <td>{!! $result->user->firstname !!}</td>
                        <td>{!! $result->user->lastname !!}</td>
                        <td>{!! $result->result !!}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="3">
                            {!! Form::open(array('class' => 'form-horizontal', 'method' => 'PUT', 'route' => 'exams.update')) !!}
                            <select class="form-control select2">
                                <option value="-1">Benutzer hinzufügen...</option>
                            </select>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                </tbody>
            </table>
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
                   url: '{!! action('UserController@index') !!}',
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
                       console.log(data.data);
                       return {
                           results: data.data
                        }
                   }
               },
               escapeMarkup: function(markup) {
                   return markup;
               },
               minimumInputLength: 1,
               templateResult: function(user) {
                   if(user.loading) return user.text;

                   return '<div class="clearfix"><div>'+user.firstname+'</div></div>';
               },
               templateSelection: function(user) {
                   return user.firstname || user.text;
               }
           });

            $('.select2').on('select2:select', function(e) {
                var user = e.params.data;
                $('#userslist').append('<tr class="clickable-row" data-href="/users/'+user.id+'">'
                        +'<td>'+user.firstname+'</td>'
                        +'<td>'+user.lastname+'</td>'
                        +'<td>'+user.birthday+'</td>'
                        +'</tr>')
            });
        });
    </script>

@endsection