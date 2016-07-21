@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">Delete Address</div>
                        <div class="panel-body">
                            <div class="list-group">
                                <div class="list-group-item">Street: {{ $address['street'] }}</div>
                                <div class="list-group-item">City: {{ $address['city'] }}</div>
                                <div class="list-group-item">State: {{ $address['state'] }}</div>
                                <div class="list-group-item">Zip: {{ $address['zip'] }}</div>
                            </div>

                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/addresses/delete') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="addressId" value="{{ $address['id'] }}">

                                <label for="delete">Are you sure?</label>
                                <div class="form-group">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash-o"></i> Yes, Delete
                                        </button>
                                        <button class="btn btn-default" type="submit">
                                            <a href="{{ url('/addresses') }}">No, go back</a>
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