@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <div class="page-header">
                    <h1>Address</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <ul class="list-group">
                                <li class="list-group-item">Street: {{ $address['street'] }}</li>
                                <li class="list-group-item">City: {{ $address['city'] }}</li>
                                <li class="list-group-item">State: {{ $address['state'] }}</li>
                                <li class="list-group-item">Zip: {{ $address['zip'] }}</li>
                                <li class="list-group-item">
                                    <button class="btn btn-primary">
                                        <a href="#">Edit</a>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">Edit</div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/addresses/update') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="addressId" value="{{ $address['id'] }}">

                                <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                    <label for="street" class="col-md-4 control-label">Street Address</label>

                                    <div class="col-md-6">
                                        <input id="street" type="text" class="form-control" name="street" value="{{ old('street') }}">

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
                                        <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}">

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
                                        <input id="state" type="text" class="form-control" name="state" value="{{ old('state') }}">

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
                                        <input id="zip" type="text" class="form-control" name="zip" value="{{ old('zip') }}">

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