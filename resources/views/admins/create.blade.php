@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create User</div>
            
                    <div class="panel-body">    
                        {!! Form::open(array('route' => 'users.store')) !!}

                            {{ Form::label('name', 'Name: ') }}
                            {{ Form::text('name', null, array('class' => 'field')) }}
                            <hr>
                            {{ Form::label('email', 'Email: ') }}
                            {{ Form::text('email', null, array('class' => 'field')) }}
                            <hr>
                            {{ Form::label('password', 'Password:') }}
                            {{ Form::text('password', null, array('class' => 'field', 'type' => 'password')) }}
                            <hr>
                            {{ Form::submit('Add New User', array('class' => 'btn btn-success btn-lg')) }}

                        {!! Form::close() !!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
