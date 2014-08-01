<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//////////////////////
//Route to Home Page//
//////////////////////
Route::get('/', function()
{
	return View::make('index');
});

////////////////////////////////
//Route to Complete Tasks Page//
////////////////////////////////
Route::get('/complete', function()
{
	//SQL statement based on Completed or not
	DB::statement('SELECT task FROM Task WHERE complete==1');

	return View::make('complete');

});

//////////////////////////////////
//Route to Incomplete Tasks Page//
//////////////////////////////////
Route::get('/incomplete', function()
{

	//SQL statement based on Completed or not
	DB::statement('SELECT task FROM Task WHERE complete<>1');

	return View::make('incomplete');
});

///////////////////////////
//Route to All Tasks Page//
///////////////////////////
Route::get('/all', function()
{
	$collection = Task::all();

	foreach($collection as $task) {
	   echo $task->name"<br>";
	}

	return View::make('all');
});

///////////////////////////////////
//Route to Create a New Task Page//
///////////////////////////////////
Route::get('/new', function()
{
	#Instantiate a new Task model class
	$task = new Task();

	#Set
	$task->name={$name}; //Task Name
	$task->duedate={$duedate}; //Date Due
	$task->complete=${$complete}; //Completed or not?

	#Save the task
	$task->save();

	return View::make('new')
	-> with('name',$name)
	-> with('duedate',$duedate)
	-> with('complete',$complete);
});

/////////////////////////////
//Route to Edit a Task Page//
/////////////////////////////
Route::get('/edit', function()
{
		# Get the Task to update
    $task = Task::where('task', '', '')->first();// ????

    # User Defined Name
    $task->name={$UserDefname}; //Task Name
		$task->duedate={$UserDefduedate}; //Date Due
		$task->complete=${$UserDefcomplete}; //Completed or not?

    # Save the changes
    $task->save();

    return

	return View::make('edit');
});
