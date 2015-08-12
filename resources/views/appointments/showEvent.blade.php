@extends('main')

@section('title', 'Termindetails')

@section('content')

    <br>
    <div class="container">
        <h1>Termindetails</h1>
        <table class="table table-hover">
            <tr>
                <td>Titel:</td>
                <td>{!! $event->title !!}</td>
            </tr>
            <tr>
                <td>Von:</td>
                @if($event->all_day)
                    <td>{!! $event->date->format('d.m.y') !!}</td>
                @else
                    <td>{!! $event->date->format('d.m.y, H:i') !!}</td>
                @endif
            </tr>
            <tr>
                <td>Bis:</td>
                @if($event->end_date)
                    @if($event->all_day)
                        <td>{!! $event->end_date->format('d.m.y') !!}</td>
                    @else
                        <td>{!! $event->end_date->format('d.m.y, H:i') !!}</td>
                    @endif
                @else
                    <td> - </td>
                @endif
            </tr>

        </table>


        {!! HTML::link('#', 'Zurück', array('class' => 'btn btn-default', 'onClick="javascript:history.back();return false;"'))!!}

    </div>

@endsection