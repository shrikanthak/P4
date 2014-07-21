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

//-------------------------------------------
//All _master page routes
Route::get('/', function()
	{
		return View::make('welcome');
	});	

//This function is called by the employee login page 
Route::post('/', function()
	{
		return View::make('welcome');
	});

Route::get('/login',function()
	{
		return View::make('login');

	});

//Route for searhing based on search string input by the user
Route::get('/search', function()
	{
		$inputString=Input::get('txtSearch');
		echo $inputString;
		return View::make('orgchart');
	});

//-------------------------------------------

