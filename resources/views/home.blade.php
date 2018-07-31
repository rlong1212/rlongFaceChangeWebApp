@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                     <p class="text-success">You are logged in as <strong>{{ Auth::user()->name }}</strong></p>
                </div>

                <div class="content">
                    <div class="links">
                        <a href="{{ url('/manipulate') }}">Start Face Manipulation</a>
                        <a href="{{ url('/savedlooks') }}">View Saved Looks</a>
                        <a href="{{ route('testimonials.create') }}">New Testimonial</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection    
 