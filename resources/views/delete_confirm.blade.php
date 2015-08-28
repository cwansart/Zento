<div class="modal fade" id="delete-confirm-dialog" tabindex="-1" role="dialog" aria-labelledby="delete-confirm-dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Wirklich löschen?</h4>
            </div>
            <div class="modal-body">
                Soll wirklich gelöscht werden?
            </div>
            <div class="modal-footer">
                {!! Form::open(['method' => 'DELETE', 'class' => 'form-horizontal']) !!}
                <button type="button" class="btn btn-default" data-dismiss="modal">Nein</button>
                <button type="submit" class="btn btn-primary">Ja</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>