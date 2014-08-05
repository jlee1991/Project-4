@extends('_master')

@section('head')
  <link rel="stylesheet" href="styles.css" type="text/css">
@stop

@section('title')
  Task Manager
@stop

@section('content')
<br><a href='/'>Return Home</a>

@if ()
  {{ Form::open(array('url' => '/edit')) }}

    Task Name:<br>
    {{ Form::text('name') }}<br><br>

@elseif (isset($_POST['name']))
    Due Date:<br>
    {{ Form::text('date') }}<br><br>

    Complete?<br>
    Yes: {{ Form::radio('Yes', 1) }}<br>
    No: {{ Form::radio('No', 0) }}<br><br>

    {{ Form::submit('Submit') }}

  {{ Form::close() }}
@endif

@stop
