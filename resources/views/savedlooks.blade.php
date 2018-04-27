@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Saved Looks</div>

                
            </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-md-8 col-md-offset-2">
    		<hr>
    		<table class="table table-striped table-bordered">
    			<thead>
    				<tr>
    					<td>User ID</td>
    					<td>Nose ID</td>
    					<td>Image</td>
    				</tr>
    			</thead>
    			<tbody>
    				<?php 
    				$savedlook = App\SavedLooks::all();
    				 ?>
    				 @foreach($savedlook as $look)
    				 <tr>
    				 	<td>{{ $look->userID }}</td>
    				 	<td>{{ $look->noseID }}</td>
    				 	<td>{{ $look->imgpath }}</td>
    				 </tr>
    				 @endforeach
    			</tbody>
    		</table>
    	</div>
    </div>
</div>
@endsection
