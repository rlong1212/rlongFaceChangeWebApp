@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-success">You are logged in as <strong>{{ Auth::user()->name }}</strong></p>
                </div>
            </div>
            <div class="content">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="links">
                            <a href="{{ route('admin.admins') }}">View and Edit Admins</a>
                            <a href="{{ route('admin.users') }}">View and Edit Users</a>
                        </div>
                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
