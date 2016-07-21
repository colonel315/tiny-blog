@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit Address</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/addresses/update') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="addressId" value="{{ $address['id'] }}">

                                <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                    <label for="street" class="col-md-4 control-label">Street Address</label>

                                    <div class="col-md-6">
                                        <input id="street" type="text" class="form-control" name="street"
                                               placeholder="{{ $address['street'] }}">

                                        @if ($errors->has('street'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="col-md-4 control-label">City</label>

                                    <div class="col-md-6">
                                        <input id="city" type="text" class="form-control" name="city"
                                               placeholder="{{ $address['city'] }}">

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                    <label for="state" class="col-md-4 control-label">State</label>

                                    <div class="col-md-6">
                                        <input id="state" type="text" class="form-control" name="state"
                                               placeholder="{{ $address['state'] }}">

                                        @if ($errors->has('state'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
                                    <label for="zip" class="col-md-4 control-label">Zip</label>

                                    <div class="col-md-6">
                                        <input id="zip" type="text" class="form-control" name="zip"
                                               placeholder="{{ $address['zip'] }}">

                                        @if ($errors->has('zip'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-archive"></i> Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </div>
@stop