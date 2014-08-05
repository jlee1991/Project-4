@extends('_master')

@section('head')
  <link rel="stylesheet" href="styles.css" type="text/css">
@stop

@section('title')
  Task Manager
@stop

@section('content')
<br><a href='/'>Return Home</a><br><br>

@foreach ($tasks as $task)
  Task: {{ $task->task }}<br>
  Due Date: {{ $task->duedate }}<br><br>
  @if($task->complete == 1)
    Complete<br><br>
  @endif
@endforeach

@stop
