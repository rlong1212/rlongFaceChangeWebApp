@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Testimonial</div>
            
                    <div class="panel-body">    
                        {!! Form::open(array('route' => 'testimonials.store')) !!}
                            {{ Form::label('star', 'Star Rating 1-5:') }}
                            {{ Form::text('star', null, array('class' => 'form-control')) }}

                            {{ Form::label('comment', 'Comment:') }}
                            {{ Form::textarea('comment', null, array('class' => 'form-control')) }}

                            {{ Form::submit('Create New Testimonial', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 20px')) }}
                        {!! Form::close() !!}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection