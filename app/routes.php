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

//Routes to Debug Controller
Route::controller('debug', 'DebugController');

//Routes to Home Page
Route::get('/', 'IndexController@getIndex');

//Routes to Signup Page
Route::get('/signup', 'UserController@getSignup');
Route::post('/signup', ['before' => 'csrf', 'uses' => 'UserController@postSignup'] );

//Routes to Login Page
Route::get('/login', 'UserController@getLogin' );
Route::post('/login', ['before' => 'csrf', 'uses' => 'UserController@postLogin'] );
Route::get('/logout', ['before' => 'auth', 'uses' => 'UserController@getLogout'] );

//Routes to Complete Tasks Page
Route::get('/complete', 'TaskController@getComplete');

//Routes to Incomplete Tasks Page
Route::get('/incomplete', 'TaskController@getIncomplete');

//Routes to All Tasks Page
Route::get('/all', 'TaskController@getAll');

//Route to Create a New Task Page
Route::get('/new', 'TaskController@getCreate');
Route::post('/new', 'TaskController@postCreate');

//Route to Edit a Task Page
Route::get('/edit/{id}', 'TaskController@getEdit');
Route::post('/edit/{id}', 'TaskController@postEdit');
