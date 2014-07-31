<?php

class AuthenticationController extends BaseController 
{

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();		

	}

	public function showWelcome()
	{
		return View::make('welcome');
	}

	public function authenticate()
	{

		$credentials=Input::only('login','password');
		
		if (Auth::attempt($credentials,$remember=false)) 
		{
		    return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
		}
		else 
		{
		    return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
		}

		return Redirect::to('login');
	
	}
	public function showLogin()
	{
		return View::make('login');

	}

	public function logout()
	{
		Auth::logout();
		return View::make('welcome');

	}


}