@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">View Admin</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <p class="text-success">Admin's Details:</p>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th></th>
                    <th></th>
                </thead>
                <tr>
                    <th> {{ $admin->id }} </th>
                    <td> {{ $admin->name }}  </td>
                    <td> {{ $admin->email }} </td>
                    <td> {{ date('M j, Y', strtotime($admin->created_at)) }} </td>
                    <td> <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">Edit</a> </td>
                    <td> 
                        <!--setting up delete method-->
                        {!! Form::open(['route' => ['admins.destroy', $admin->id], 'method' => 'DELETE']) !!}
                        {{ Form::submit('Delete', ["class" => 'btn btn-danger']) }} 
                        {!! Form::close() !!}
                    </td>
                </tr>
            </table>
            <a class="btn btn-lg btn-default" href="{{ route('admin.admins') }}">Back</a>                 
        </div>          
    </div>
</div> 
      
@endsection
