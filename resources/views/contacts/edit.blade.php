@extends('layouts.metronic')

@section('page-title', 'Contacts')

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
                    <h3 class="m-portlet__head-text">
                        Add New Contact
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        {!! Form::model($contact, ['action' => ['ContactController@update', $contact->id], 'method' => 'PATCH', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row {{ $errors->has('name') ? 'has-danger' : '' }}">
                {!! Form::label('name', 'Name', ['class' => 'col-2 col-form-label']) !!}
                <div class="col-10">
                    {!! Form::text('name', old('name'), ['class' => 'form-control m-input']) !!}
                    @if($errors->has('name'))
                        <div class="form-control-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>

            </div>
            <div class="form-group m-form__group row {{ $errors->has('number') ? 'has-danger' : '' }}">
                {!! Form::label('number', 'Number', ['class' => 'col-2 col-form-label']) !!}
                <div class="col-10">
                    {!! Form::text('number', old('number'), ['class' => 'form-control m-input']) !!}
                    @if($errors->has('number'))
                        <div class="form-control-feedback">{{ $errors->first('number') }}</div>
                    @endif
                </div>

            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions m--align-right">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    {!! Form::close() !!}
    <!--end::Form-->
    </div>

@endsection