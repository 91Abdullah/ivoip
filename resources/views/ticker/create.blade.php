@extends('layouts.metronic')

@section('page-title', 'Tickers')

@section('content')

    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-multimedia"></i>
                    </span>
                    <h3 class="m-portlet__head-text">
                        Create a new ticker
                    </h3>
                </div>
            </div>
        </div>
        <form action="{{ route('ticker.store') }}" method="post">
            <div class="m-portlet__body">
                @csrf
                <div class="form-group m-form__group">
                    <label for="content">Content</label>
                    <input value="{{ old('content') }}" id="content" name="content" type="text" class="form-control m-input--air">
                </div>
            </div>
            <div class="m-portlet__foot">
                <div class="row align-items-center">
                    <div class="col-lg-6 m--valign-middle">
                        <button type="submit" class="btn btn-brand">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection