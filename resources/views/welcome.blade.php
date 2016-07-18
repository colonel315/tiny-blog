@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @if(Auth::guest())
                    <div class="panel-heading">Welcome</div>

                    <div class="panel-body">
                        Your Application's Landing Page.
                    </div>
                @else
                    <div class="panel-heading">Status Update</div>

                    <div class="panel-body">
                        <form class='form-horizontal' role='form' action="{{ url('/new-status') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="status">
                            <input type="submit" class="btn btn-primary">
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
