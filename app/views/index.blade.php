@extends('_master')

@section('title')
  Task Manager

@stop

@section('content')

  <h1>Task Manager</h1>
  <p>Keep track of your ongoing tasks, complete existing ones, or add/edit new tasks!</p>
  <a href='complete'>Complete Tasks</a> <br>
  <a href='incomplete'>Incomplete Tasks</a> <br>
  <a href='all'>Display All Tasks</a> <br>
  <a href='new'>Add a New Task</a> <br>
  <a href='edit'>Edit Tasks</a>

@stop
