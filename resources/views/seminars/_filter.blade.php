<div class="container">
    <table>
        <tr>
            <td>
                <div class="input-group">
                    {!! Form::input('text', 's', $filterSearch, ['class' => 'form-control', 'id' => 'filterS', 'placeholder' => 'Suche...']) !!}
                    <span class="input-group-btn"><button class="btn btn-default" id="set-filter" type="button">Los!</button></span>
                </div>
            </td>
        </tr>
    </table>
</div>