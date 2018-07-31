@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">View and Edit Admins</div>

                
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
    				$admin = App\Admin::all();
    				 ?>
    				 @foreach($admin as $a)
    				 <tr>
    				 	<td>{{ $a->id }}</td>
    				 	<td>{{ $a->name }}</td>
    				 	<td>{{ $a->email }}</td>
                        <td><a href="{{ route('admins.show', $a->id) }}" class="btn btn-default">View</a>
    				 </tr>
    				 @endforeach
    			</tbody>
    		</table>
            <a href="{{ route('admins.create') }}" class="btn btn-lg btn-success">Create New Admin</a>   <a class="btn btn-lg btn-default" href="{{ route('admin.dashboard') }}">Back</a>
    	</div>
    </div>
</div>
@endsection