@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">View and Edit Users</div>

                
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-8 col-md-offset-2">
    		
    		<table class="table table-striped table-bordered">
    			<thead>
    				<tr>
    					<td>ID</td>
    					<td>Name</td>
    					<td>Email</td>
    				</tr>
    			</thead>
    			<tbody>
    				<?php 
    				$user = App\User::all();
    				 ?>
    				 @foreach($user as $u)
    				 <tr>
    				 	<td>{{ $u->id }}</td>
    				 	<td>{{ $u->name }}</td>
    				 	<td>{{ $u->email }}</td>
                        <td><a href="{{ route('users.edit', $u->id) }}" class="btn btn-warning">Edit</a> <a href="{{ route('users.destroy', $u->id) }}" class="btn btn-danger">Delete</a></td>
    				 </tr>
    				 @endforeach
    			</tbody>
    		</table>
            <a href="{{ route('users.create') }}" class="btn btn-lg btn-success">Create New User</a>
    	</div>
    </div>
</div>
@endsection
