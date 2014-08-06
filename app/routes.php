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

////////////////////////
//Route to Debug Route//
////////////////////////
# /app/routes.php
Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    }
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});

//////////////////////
//Route to Home Page//
//////////////////////
Route::get('/', function()
{
	return View::make('index');
});

Route::get('/logout', function()
{
	return View::make('login');
});

////////////////////////
//Route to Signup Page//
////////////////////////
Route::get('/signup',
    array(
        'before' => 'guest',
        function() {
            return View::make('signup');
        }
    )
);

Route::post('/signup',
    array(
        'before' => 'csrf',
        function() {

						#Define the rules
						$rules = array(
							'email' => 'required|email|unique:users,email', //Required, email format, and unique user/email
							'password' => 'required'
						);

						#Run rules and data through validator
						$validator = Validator::make(Input::all(), $rules);

						#Give the user feedback
						if($validator->fails()) {

							return Redirect::to('/signup')
								->with('flash_message', 'Sign up failed; please fix the errors listed below.')
								->withInput()
								->withErrors($validator);
						}

            $user = new User;
            $user->email    = Input::get('email');
            $user->password = Hash::make(Input::get('password')); //Hash the password!

            #Try/Catch Statement to add the user
            try {
                $user->save();
            }
            catch (Exception $e) {
                return Redirect::to('/signup')
									->with('flash_message', 'Sign up failed; please try again.')
									->withInput();
            }

            #User Log In
            Auth::login($user);

            return Redirect::to('/')->with('flash_message', 'Welcome to the Task Manager');

        }
    )
);

///////////////////////
//Route to Login Page//
///////////////////////
Route::get('/login',
    array(
        'before' => 'guest',
        function() {
            return View::make('login');
        }
    )
);

Route::post('/login',
    array(
        'before' => 'csrf',
        function() {

            $credentials = Input::only('email', 'password');

            if (Auth::attempt($credentials, $remember = true)) {
                return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
            }
            else {
                return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
            }

            return Redirect::to('login');
        }
    )
);

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/');

});

////////////////////////////////
//Route to Complete Tasks Page//
////////////////////////////////
Route::get('/complete', function()
{

	//SQL statement based on Completed or not
	$tasks = Task::where('complete','=', 1) -> where('user_id','=', Auth::user()->id) -> get();

	return View::make('complete')
		-> with('tasks', $tasks);

});

//////////////////////////////////
//Route to Incomplete Tasks Page//
//////////////////////////////////
Route::get('/incomplete', function()
{
	//SQL statement based on Completed or not
	$tasks = Task::where('complete','=', 0) -> where('user_id','=', Auth::user()->id) -> get();

	return View::make('incomplete')
		-> with('tasks', $tasks);
});

///////////////////////////
//Route to All Tasks Page//
///////////////////////////
Route::get('/all', function()
{
	//SQL statement based on Completed or not
	$tasks = Task::where('user_id','=', Auth::user()->id) -> get();

	return View::make('all')
		-> with('tasks', $tasks);

});

///////////////////////////////////
//Route to Create a New Task Page//
///////////////////////////////////
Route::get('/new', function()
{
		return View::make('new');
});

Route::post('/new', function()
{

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

});


/////////////////////////////
//Route to Edit a Task Page//
/////////////////////////////
Route::get('/edit/{id}', function($id)
{

	$task = Task::find($id);

	return View::make('edit') -> with('task', $task);

});

Route::post('/edit/{id}', function($id)
{

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
			->with('flash_message', 'Sign up failed; please fix the errors listed below.')
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

});
