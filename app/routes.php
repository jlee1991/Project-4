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

Route::get('/', function()
{
	return View::make('index');
});

//Route to Complete Tasks Page
Route::get('/complete', function()
{
	return View::make('complete');
		//-> with('paragraphs',$paragraphs);
});

//Route to Incomplete Tasks Page
Route::get('/incomplete', function()
{
	return View::make('incomplete');
});

//Route to All Tasks Page
Route::get('/all', function()
{
		return View::make('all');
});

//Route to Create a New Task Page
Route::get('/new', function()
{
	return View::make('new');
});

//Route to Edit a Task Page
Route::get('/edit', function()
{
	return View::make('edit');
});
