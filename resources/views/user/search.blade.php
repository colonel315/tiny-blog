@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/search-users') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="search" class="col-sm-2">Search Users:</label>
                        <div class="col-sm-8">
                            <input type="text" name='query' class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                @if(is_null($data) || count($data) === 0)
                    <div class="col-sm-8 col-sm-offset-4">
                        <h1>No results.</h1>
                    </div>
                @else
                    <table class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>City</th>
                            <th>State</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < count($data); $i++)
                            <tr>
                                <td>{{ $data[$i]->first_name }}</td>
                                <td>{{ $data[$i]->last_name }}</td>
                                <td>{{ $data[$i]->city }}</td>
                                <td>{{ $data[$i]->state }}</td>
                                <td>
                                    <button class="btn btn-primary">
                                        <a href="{{ url('/viewUser/' . $data[$i]->username) }}">
                                            View {{ $data[$i]->first_name }} {{ $data[$i]->last_name }}'s Profile
                                        </a>
                                    </button>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@stop