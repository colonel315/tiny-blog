@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="pull-right">
                    @if(Auth::user()->userRelationships()->where('relationship_id', $data['user']->id)->where('type', 'Block')->exists())
                        <form action="{{ url('/unblock/' . $data["user"]->id) }}" method="post" class="form-horizontal">
                            <input type="hidden" name="id" value="{{ $data['user']->id }}">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-warning">
                                Unblock {{ $data["user"]->first_name }} {{ $data["user"]->last_name }}
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/block/' . $data["user"]->id) }}" method="post" class="form-horizontal">
                            <input type="hidden" name="id" value="{{ $data['user']->id }}">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-danger">
                                Block {{ $data["user"]->first_name }} {{ $data["user"]->last_name }}
                            </button>
                        </form>
                    @endif
                </div>
                <div class="pull-right">
                    @if(Auth::user()->userRelationships()->where('relationship_id', $data['user']->id)->where('type', 'Friend')->exists())
                        <form action="{{ url('/unfriend/' . $data["user"]->id) }}" method="post"
                              class="form-horizontal">
                            <input type="hidden" name="id" value="{{ $data['user']->id }}">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-warning" style="margin-right: 15px;">
                                Unfriend {{ $data["user"]->first_name }} {{ $data["user"]->last_name }}
                            </button>
                        </form>
                    @else
                        <form action="{{ url('/friend/' . $data["user"]->id) }}" method="post" class="form-horizontal">
                            <input type="hidden" name="id" value="{{ $data['user']->id }}">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                Friend {{ $data["user"]->first_name }} {{ $data["user"]->last_name }}
                            </button>
                        </form>
                    @endif
                </div>
                <h3 class="h3">General Info</h3>
                <div class="list-group">
                    <div class="list-group-item">First Name: {{ $data["user"]->first_name }}</div>
                    <div class="list-group-item">Last Name: {{ $data["user"]->last_name }}</div>
                    <div class="list-group-item">Username: {{ $data["user"]->username }}</div>
                    <div class="list-group-item">Email: {{ $data["user"]->email }}</div>
                    <div class="list-group-item">About Me: {{ $data["user"]->description }}</div>
                    <div class="list-group-item">High School: {{ $data["user"]->high_school }}</div>
                </div>

                <h3 class="h3">Addresses</h3>
                <div class="list-group">
                    @for($i = 0; $i < count($data["addresses"]); $i++)
                        <h5 class="h5">Address {{ $i+1 }}</h5>
                        <div class="list-group-item">Street: {{ $data["addresses"][$i]->street }}</div>
                        <div class="list-group-item">City: {{ $data["addresses"][$i]->city }}</div>
                        <div class="list-group-item">State: {{ $data["addresses"][$i]->state }}</div>
                        <div class="list-group-item">Zip: {{ $data["addresses"][$i]->zip }}</div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
@stop