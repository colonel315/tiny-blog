@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <div class="page-header">
                    <h1>Settings</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <ul class="list-group">
                    <li class="list-group-item">
                        <button id="name" class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Name: {{ $data['name'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="name">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Username: {{ $data['username'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="username">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Email: {{ $data['email'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="email" class='form-control' name="email">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        High School: {{ $data['high_school'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="high_school">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Description: {{ $data['description'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="description">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Change Password
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="password" class='form-control' name="new_password">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item"><a href="{{ url('/addresses') }}">Manage Addresses</a></li>
                </ul>
            </div>
        </div>
    </div>
@stop