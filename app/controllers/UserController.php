<?php

class UserController extends BaseController {

	public function __construct() {
    $this->beforeFilter('guest', array('only' => array('getLogin','getSignup')));
  }

  public function getSignup() {
		return View::make('signup');
	}

  public function postSignup() {

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

	public function getLogin() {

		return View::make('login');

	}

	public function postLogin() {
		$credentials = Input::only('email', 'password');

		if (Auth::attempt($credentials, $remember = true)) {
			return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
		}
		else {
			return Redirect::to('/login')
				->with('flash_message', 'Log in failed; please try again.')
				->withInput();
		}
		return Redirect::to('login');
	}


	public function getLogout() {
		# Log out
		Auth::logout();

		# Send them to the homepage
		return Redirect::to('/');
  }

}
