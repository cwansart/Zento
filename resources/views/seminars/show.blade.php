@extends('main')

@section('title', 'Teilnehmer „'.$title.'“')

@section('content')

    <div class="container">
        <h1>Teilnehmer des Seminars „{!! $title !!}“</h1>
        @if(count($seminarUsers))
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Vorname</th>
                    <th>Nachname</th>
                </tr>
                </thead>
                <tbody>
                @foreach($seminarUsers as $seminarUser)
                    <tr class="clickable-row" data-href="{{ action('UserController@show', [$seminarUser->id]) }}">
                        <td>{!! $seminarUser->firstname !!}</td>
                        <td>{!! $seminarUser->lastname !!}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="3">
                        {!! Form::open(array('id' => 'add-seminar-form', 'class' => 'form-horizontal', 'method' => 'PUT', 'route' => array('seminars.update', $seminar->id))) !!}
                        <select class="form-control select2" id="userid" name="userid">
                            <option value="-1">Benutzer hinzufügen...</option>
                        </select>
                        {!! Form::close() !!}
                    </td>
                </tr>
                </tbody>
            </table>
        @else
            <p>Keine Benutzer im Seminar eingetragen!</p>
        @endif

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
                        console.log(data);
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