@extends('layouts.metronic')

@section('page-title', 'Voicemail')

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
					<span class="m-portlet__head-icon m--hide">
					<i class="la la-gear"></i>
					</span>
                    <h3 class="m-portlet__head-text">
                        Create Voicemail User
                    </h3>
                </div>
            </div>
        </div>
        <!--begin::Form-->
        {!! Form::open(['action' => 'VoicemailController@store', 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--state']) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group {{ $errors->has('context') ? 'has-danger' : '' }}">
                {!! Form::label('context', 'Context') !!}
                {!! Form::text('context', old('context'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('context'))
                    <div class="form-control-feedback">{{ $errors->first('context') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('mailbox') ? 'has-danger' : '' }}">
                {!! Form::label('mailbox', 'Mailbox') !!}
                {!! Form::text('mailbox', old('mailbox'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('mailbox'))
                    <div class="form-control-feedback">{{ $errors->first('mailbox') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('password') ? 'has-danger' : '' }}">
                {!! Form::label('password', 'Password') !!}
                {!! Form::text('password', old('password'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('password'))
                    <div class="form-control-feedback">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('fullname') ? 'has-danger' : '' }}">
                {!! Form::label('fullname', 'Full Name') !!}
                {!! Form::text('fullname', old('fullname'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('fullname'))
                    <div class="form-control-feedback">{{ $errors->first('fullname') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('alias') ? 'has-danger' : '' }}">
                {!! Form::label('alias', 'Alias') !!}
                {!! Form::text('alias', old('alias'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('alias'))
                    <div class="form-control-feedback">{{ $errors->first('alias') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('email') ? 'has-danger' : '' }}">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('email'))
                    <div class="form-control-feedback">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('pager') ? 'has-danger' : '' }}">
                {!! Form::label('pager', 'Pager') !!}
                {!! Form::text('pager', old('pager'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('pager'))
                    <div class="form-control-feedback">{{ $errors->first('pager') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('attach') ? 'has-danger' : '' }}">
                {!! Form::label('attach', 'Attach?') !!}
                {!! Form::select('attach', ["yes" => "Yes", "no" => "No"], old('attach'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('attach'))
                    <div class="form-control-feedback">{{ $errors->first('attach') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('deletevoicemail') ? 'has-danger' : '' }}">
                {!! Form::label('deletevoicemail', 'Delete Voicemail') !!}
                {!! Form::select('deletevoicemail', ["yes" => "Yes", "no" => "No"], old('deletevoicemail'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('deletevoicemail'))
                    <div class="form-control-feedback">{{ $errors->first('deletevoicemail') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('saycid') ? 'has-danger' : '' }}">
                {!! Form::label('saycid', 'Say CID') !!}
                {!! Form::select('saycid', ["yes" => "Yes", "no" => "No"], old('saycid'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('saycid'))
                    <div class="form-control-feedback">{{ $errors->first('saycid') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('sendvoicemail') ? 'has-danger' : '' }}">
                {!! Form::label('sendvoicemail', 'Send Voicemail') !!}
                {!! Form::select('sendvoicemail', ["yes" => "Yes", "no" => "No"], old('sendvoicemail'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('sendvoicemail'))
                    <div class="form-control-feedback">{{ $errors->first('sendvoicemail') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('review') ? 'has-danger' : '' }}">
                {!! Form::label('review', 'Review?') !!}
                {!! Form::select('review', ["yes" => "Yes", "no" => "No"], old('review'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('review'))
                    <div class="form-control-feedback">{{ $errors->first('review') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('tempgreetwarn') ? 'has-danger' : '' }}">
                {!! Form::label('tempgreetwarn', 'Temp Greeting Warning') !!}
                {!! Form::select('tempgreetwarn', ["yes" => "Yes", "no" => "No"], old('tempgreetwarn'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('tempgreetwarn'))
                    <div class="form-control-feedback">{{ $errors->first('tempgreetwarn') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('operator') ? 'has-danger' : '' }}">
                {!! Form::label('operator', 'Operator') !!}
                {!! Form::select('operator', ["yes" => "Yes", "no" => "No"], old('operator'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('operator'))
                    <div class="form-control-feedback">{{ $errors->first('operator') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('envelope') ? 'has-danger' : '' }}">
                {!! Form::label('envelope', 'Envelop') !!}
                {!! Form::select('envelope', ["yes" => "Yes", "no" => "No"], old('envelope'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('envelope'))
                    <div class="form-control-feedback">{{ $errors->first('envelope') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('forcegreetings') ? 'has-danger' : '' }}">
                {!! Form::label('forcegreetings', 'Force Greetings') !!}
                {!! Form::select('forcegreetings', ["yes" => "Yes", "no" => "No"], old('forcegreetings'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('forcegreetings'))
                    <div class="form-control-feedback">{{ $errors->first('forcegreetings') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('forcename') ? 'has-danger' : '' }}">
                {!! Form::label('forcename', 'Force Name') !!}
                {!! Form::select('forcename', ["yes" => "Yes", "no" => "No"], old('forcename'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('forcename'))
                    <div class="form-control-feedback">{{ $errors->first('forcename') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('sayduration') ? 'has-danger' : '' }}">
                {!! Form::label('sayduration', 'Say Duration') !!}
                {!! Form::text('sayduration', old('sayduration'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('sayduration'))
                    <div class="form-control-feedback">{{ $errors->first('sayduration') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('attachfmt') ? 'has-danger' : '' }}">
                {!! Form::label('attachfmt', 'Attach FMT') !!}
                {!! Form::text('attachfmt', old('attachfmt'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('attachfmt'))
                    <div class="form-control-feedback">{{ $errors->first('attachfmt') }}</div>
                @endif
            </div>
            <div class="form-group m-form__group {{ $errors->has('attachfmt') ? 'has-danger' : '' }}">
                {!! Form::label('serveremail', 'Server Email') !!}
                {!! Form::text('serveremail', old('serveremail'), ['class' => 'form-control m-input']) !!}
                @if($errors->has('serveremail'))
                    <div class="form-control-feedback">{{ $errors->first('attachfmt') }}</div>
                @endif
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                <button type="reset" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    {!! Form::close() !!}
    <!--end::Form-->
    </div>

@endsection