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
                <div class="container-fluid">
                    <div class="row">
                        {!! Form::open(array('class' => 'form-horizontal', 'method' => 'POST', 'route' => 'exams.store')) !!}
                        @include('exams._form')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                {!! Form::submit('Prüfung anlegen', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
            </div>
        </div>

    </div>
</div>
@if(count($errors))
    <script>
        $(function() {
            $('#myModal').modal('show');
        });
    </script>
@endif
