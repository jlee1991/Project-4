<?php

class TaskController extends BaseController {

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();

		# Only logged in users should have access to this controller
		$this->beforeFilter('auth');

	}

  public function getComplete(){

    $tasks = Task::where('complete','=', 1) -> where('user_id','=', Auth::user()->id) -> get();

    return View::make('complete')
      -> with('tasks', $tasks);

  }

  public function getIncomplete(){

    $tasks = Task::where('complete','=', 0) -> where('user_id','=', Auth::user()->id) -> get();

    return View::make('incomplete')
      -> with('tasks', $tasks);

  }

  public function getAll(){

    $tasks = Task::where('user_id','=', Auth::user()->id) -> get();

    return View::make('all')
      -> with('tasks', $tasks);

  }

  public function getCreate(){

    return View::make('new');

  }

  public function postCreate(){

    $data = Input::all();

    #Define the rules
    $rules = array(
      'name' => 'required',
      'duedate' => 'required',
      'complete' => 'required'
    );

    #Run rules and data through validator
    $validator = Validator::make($data, $rules);

    #Give the user feedback
    if($validator->fails()) {

      return Redirect::to('/new')
        ->with('flash_message', 'Sign up failed; please fix the errors listed below.')
        ->withInput()
        ->withErrors($validator);
    }

    #Instantiate a new Task model class
    $task = new Task();

    #Set
    $task->task = $data['name']; //Task Name
    $task->complete = $data['complete']; //Complete of not?
    $task->duedate = $data['duedate'];
    $task->user_id = Auth::user()->id;

    #Date Due
    //$date = $data['duedate'];
    //$newdate = date(“F j y”, time($date))
    //$task->duedate = $newdate;

    #Save the task
    $task->save();

    return View::make('new');

  }

  public function getEdit($id){

    $task = Task::find($id);

    return View::make('edit') -> with('task', $task);
  }

  public function postEdit($id){

  $data = Input::all();

  #Define the rules
  $rules = array(
    'name' => 'required',
    'duedate' => 'required',
    'complete' => 'required'
  );

  #Run rules and data through validator
  $validator = Validator::make($data, $rules);

  #Give the user feedback
  if($validator->fails()) {

    return Redirect::to('/edit/{id}')
      ->with('flash_message', 'Error, please review the form!')
      ->withInput()
      ->withErrors($validator);
  }

  $task = Task::find($id);

  # User Defined Name
  $task->task = $data['name']; //Task Name
  $task->complete = $data['complete']; //Complete of not?
  $task->duedate = $data['duedate'];

  # Save the changes
  $task->save();

  return View::make('edit') -> with('task', $task);

  }

}
