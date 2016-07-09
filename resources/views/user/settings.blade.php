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

                        First Name: {{ $data['first_name'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="first_name">
                            <input type="submit" class="btn btn-default btn-sm">
                        </form>
                    </li>
                    <li class="list-group-item">
                        <button id="name" class="btn btn-xs btn-primary pull-right">
                            <a href="#">Edit</a>
                        </button>

                        Last Name: {{ $data['last_name'] }}
                        <form class='form-horizontal hidden' role='form' action="{{ url('/update') }}" method='post'>
                            {{ csrf_field() }}
                            <input type="text" class='form-control' name="last_name">
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
                            <a href="{{ url('/change-password') }}">Edit</a>
                        </button>

                        Change Password
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="{{ url('/addresses') }}">Edit</a>
                        </button>

                        Manage Addresses
                    </li>
                    <li class="list-group-item">
                        <button class="btn btn-xs btn-primary pull-right">
                            <a href="{{ url('/blocked-users') }}">Edit</a>
                        </button>

                        Manage Blocked Users
                    </li>
                </ul>
            </div>
        </div>
    </div>
@stop