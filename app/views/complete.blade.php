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
  <a href='edit/{{ $task->id }}'>Edit {{ $task->task }}</a><br>
  <i>Task:</i> {{ $task->task }}<br>
  <i>Due Date:</i>  {{ $task->duedate }}</p>
@endforeach

@stop
