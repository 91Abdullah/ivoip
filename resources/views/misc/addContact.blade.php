<div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    Add Contact
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
                </button>
            </div>
            {!! Form::open(['method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right', 'id' => 'submitContact']) !!}
            <div class="modal-body">
                <div class="form-group m-form__group row">
                    {!! Form::label('name', 'Name', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10">
                        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    {!! Form::label('add_number', 'Number', ['class' => 'col-2 col-form-label']) !!}
                    <div class="col-10">
                        {!! Form::text('add_number', null, ['class' => 'form-control m-input', 'required' => 'required']) !!}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Close
                </button>
                {!! Form::submit('Save changes', ['class' => 'btn btn-success']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>