@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default panel">
                    <div class="panel-heading">Status Update</div>

                    <div class="panel-body">
                        <form class='form-horizontal' role='form' action="{{ url('/new-status') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="status">
                            <input type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @for($i = 0; $i < count($statuses); $i++)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel panel-default panel">
                        <div class="panel-heading">
                            <a href="{{ url('/viewUser/'.$statuses[$i]->username) }}">
                                {{ $statuses[$i]->first_name }} {{ $statuses[$i]->last_name }}
                            </a>
                        </div>

                        <div class="panel-body">
                            {{ $statuses[$i]->status }}
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endsection
