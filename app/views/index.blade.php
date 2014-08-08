@extends('_master')

@section('title')
  Task Manager

@stop

@section('content')

  <h1>Task Manager</h1>
  <p>Keep track of your ongoing tasks, complete existing ones, or add/edit new tasks!</p>
  <b>Start Here</b><br>
  <a href='new'>Add a New Task</a> <br><br>
  <b>Keep Track!</b><br>
  <a href='complete'>Complete Tasks</a> <br>
  <a href='incomplete'>Incomplete Tasks</a> <br>
  <a href='all'>Display All Tasks</a> <br>

@stop
