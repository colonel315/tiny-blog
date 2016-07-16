@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <div class="page-header">
                    <h1>Addresses</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="pull-right">
                    <button class="btn btn-lg btn-warning">
                        <a href="{{ url('/addresses/add') }}">Add</a>
                    </button>
                </div>
                <ul class="list-group">
                    @if(count($addresses) > 1)
                        @for($i = 0; $i < count($addresses); $i++)
                            <div class="panel panel-heading">
                                <div class="panel-heading">Address {{ $i+1 }}</div>
                                <div class="panel-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">Street: {{ $addresses[$i]->street }}</li>
                                        <li class="list-group-item">City: {{ $addresses[$i]->city }}</li>
                                        <li class="list-group-item">State: {{ $addresses[$i]->state }}</li>
                                        <li class="list-group-item">Zip: {{ $addresses[$i]->zip }}</li>
                                        <li class="list-group-item">
                                            <button class="btn btn-primary">
                                                <a href="{{ url('/addresses/' . $addresses[$i]->id) }}">Edit</a>
                                            </button>
                                            <button class="btn btn-danger">
                                                <a href="{{ url('/addresses/delete/' . $addresses[$i]->id) }}">Delete</a>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endfor
                    @else
                        <div class="panel panel-heading">
                            <div class="panel-heading">Address {{ 1 }}</div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Street: {{ $addresses[0]->street }}</li>
                                    <li class="list-group-item">City: {{ $addresses[0]->city }}</li>
                                    <li class="list-group-item">State: {{ $addresses[0]->state }}</li>
                                    <li class="list-group-item">Zip: {{ $addresses[0]->zip }}</li>
                                    <li class="list-group-item">
                                        <button class="btn btn-primary">
                                            <a href="{{ url('/addresses/' . $addresses[0]->id) }}">Edit</a>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@stop