@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Show New User</div>
                    <!--displaying the new added user-->
                    <div class="panel-body"> 
                        <p class="text-success">Your New User's Details:</p> 
                        <p class="lead">{{ $user->name }}</p>
                        <p class="lead">{{ $user->email }}</p>
                    </div>
                    
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
