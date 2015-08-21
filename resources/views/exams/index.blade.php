@extends('main')

@section('title', 'Prüfungsübersicht')

@section('content')

    <div class="container">


        <h1>Prüfungsübersicht</h1>
        @if(count($exams))
            <table class="table table-hover table-exam">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Ort</th>
                        <th>Teilnehmer</th>
                        @if(Auth::user()->is_admin)
                            <th>Aktion</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($exams as $exam)
                        <tr class="clickable-row" data-href="{{ action('ExamController@show', [$exam->id]) }}">
                            <td>{!! $exam->date !!}</td>
                            <td>{!! $exam->addressStr() !!}</td>
                            <td>{!! $exam->users->count() !!}</td>
                            @if(Auth::user()->is_admin)
                                <td>
                                    {!! Form::open(['action' => ['ExamController@destroy', $exam->id], 'method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                                    {!! Html::linkAction('ExamController@edit', '', [$exam->id], ['class' => 'edit']) !!}
                                    {!! Form::submit('', ['class' => 'delete']) !!}
                                    {!! Form::close() !!}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            Noch keine Prüfungen vorhanden!
        @endif
    </div>

    {!! $exams->render() !!}

    <hr>

    @if(Auth::user()->is_admin)
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Prüfung erstellen</button>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Prüfung erstellen</h4>
                    </div>
                    <div class="modal-body">
                        @include('exams.createFormContainer')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div>

            </div>
        </div>
    @endif

@endsection