@extends('_master')

@section('title')
  Task Manager
@stop

@section('content')

@foreach($errors->all() as $message)
  <div class="error">{{ $message}}</div>
@endforeach

<br><a href='/'>Return Home</a><br><br>

  {{ Form::open(array('url' => '/new')) }}

    Task Name:<br>
    {{ Form::text('name') }}<br><br>

    Due Date:<br>
    {{ Form::text('duedate') }}<br><br>

    Complete?<br>
    Yes: {{ Form::checkbox('complete', 1) }}<br>
    No: {{ Form::checkbox('complete', 0) }}<br><br>

    {{ Form::submit('Submit') }}

  {{ Form::close() }}

@stop
