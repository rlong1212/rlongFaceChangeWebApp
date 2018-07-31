@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>
            </div>
        </div>
    </div>
    <div class="row">
        <!--binding model to the form-->
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}

        <div class="col-md-8 col-md-offset-2">

            <p class="text-success">Edit User's Details:</p>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                    <th></th>
                </thead>
                <tr>
                    <th> {{ $user->id }} </th>
                    <!--create a text field to edit name-->
                    <td> {{ Form::text('name', null, ["class" => 'form-control']) }} </td>
                    <!--create a text field to edit email-->
                    <td> {{ Form::text('email', null, ["class" => 'form-control']) }} </td>
                    <td> {{ date('M j, Y h:ia', strtotime($user->created_at)) }} </td>
                    <td> {{ date('M j, Y h:ia', strtotime($user->updated_at)) }} </td>
                    <td> <a href="{{ route('users.show', $user->id) }}" class="btn btn-danger">Cancel</a> </td>
                    <td> {{ Form::submit('Save', ["class" => 'btn btn-success']) }} </td>
                </tr>
            </table>
            <a class="btn btn-lg btn-default" href="{{ route('admin.users') }}">Back</a>                 
        </div>          
    </div>
    {!! Form::close() !!}
</div> 
      
@endsection
