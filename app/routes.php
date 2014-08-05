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
								/*->with('flash_message', 'Sign up failed; please fix the errors listed below.')*/
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
									/*->with('flash_message', 'Sign up failed; please try again.')*/
									->withInput();
            }

            #User Log In
            Auth::login($user);

            return Redirect::to('/')/*->with('flash_message', 'Welcome to the Task Manager')*/;

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
                return Redirect::intended('/')/*->with('flash_message', 'Welcome Back!')*/;
            }
            else {
                return Redirect::to('/login')/*->with('flash_message', 'Log in failed; please try again.')*/;
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
	//$complete = DB::statement('SELECT task, duedate FROM tasks WHERE complete = \'1\' AND user_id = "Auth::user()->id" ');
	$tasks = Task::where('complete','=', 1) -> where('user_id','=', Auth::user()->id) -> get();

	//$tasks = DB::table('tasks')->get();

	/*foreach ($task as $tasks) {
  	var_dump($task->task);
	}*/

	return View::make('complete')
		-> with('tasks', $tasks);

});

/*Route::post('/complete', function()
{

	//SQL statement based on Completed or not
	$complete = DB::statement('SELECT task, duedate FROM Task WHERE complete = 1');

	return View::make('complete') -> with($complete,'complete');

});*/

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

Route::post('/incomplete', function()
{
	//SQL statement based on Completed or not
	DB::statement('SELECT task FROM Task WHERE complete==0');

	return View::make('incomplete');
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

Route::post('/all', function()
{
	$collection = Task::all();

	foreach($collection as $task) {
		echo $task->name."<br>";
	}

	return View::make('all');
});

///////////////////////////////////
//Route to Create a New Task Page//
///////////////////////////////////
Route::get('/new', function()
{

	if(isset($_POST['name']) && isset($_POST['duedate']) && isset($_POST['complete'])){

		dd(Input::all());

		#Instantiate a new Task model class
		$task = new Task();

		#Set
		$task->name=$_POST['name']; //Task Name
		$task->duedate=$_POST['duedate']; //Date Due
		$task->complete=$_POST['complete']; //Completed or not?

		#Save the task
		$task->save();

		return View::make('new');
	}

	else{
		return View::make('new');
	}
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
				/*->with('flash_message', 'Sign up failed; please fix the errors listed below.')*/
				->withInput()
				->withErrors($validator);
		}

		#Instantiate a new Task model class
		$task = new Task();

		#Set
		$task->task = $data['name']; //Task Name
		$task->duedate = $data['duedate']; //Date Due
		$task->complete = $data['complete'];
		$task->user_id = Auth::user()->id;

		#Save the task
		$task->save();

		return View::make('new');

});


/////////////////////////////
//Route to Edit a Task Page//
/////////////////////////////
Route::get('/edit', function()
{/*
		# Get the Task to update
    $task = Task::where('task', '', '')->first();// ????

    # User Defined Name
    $task->name={$UserDefname}; //Task Name
		$task->duedate={$UserDefduedate}; //Date Due
		$task->complete=${$UserDefcomplete}; //Completed or not?

    # Save the changes
    $task->save();*/

	return View::make('edit');
});
