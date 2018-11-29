@extends('layouts.portlet')

@section('page-title', 'Conference')

@section('new_record_link', action('ConferenceController@create'))

@section('body')

    {!! Form::open(['action' => 'ConferenceController@store', 'method' => 'post', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('starttime', 'Start Time', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('starttime', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('endtime', 'End Time', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('endtime', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        {!! Form::label('confno', 'Conference No', ['class' => 'col-2 col-form-label']) !!}
        <div class="col-10">
            {!! Form::text('confno', null, ['class' => 'form-control m-input']) !!}
        </div>
    </div>

    <div class="m-form__actions">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-10">
                <button type="reset" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
