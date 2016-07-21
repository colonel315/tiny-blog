@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i < count($blocked); $i++)
                        <tr>
                            <td>
                                {{ $blocked[$i]->first_name }}
                            </td>
                            <td>
                                {{ $blocked[$i]->last_name }}
                            </td>
                            <td>
                                <form action="{{ url('/unblock/' . $blocked[$i]->id) }}" method="post"
                                      class="form-horizontal">
                                    <input type="hidden" name="id" value="{{ $blocked[$i]->id }}">
                                    {{ csrf_field() }}

                                    <button type="submit" class="btn btn-primary">
                                        Unblock
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop