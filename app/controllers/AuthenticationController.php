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

	public function getResetPasswordPage()
	{
		return View::make('resetpassword');
	}

	public function resetPassword()
	{
		$credentials=['login'=>Auth::user()->login, 'password'=>Input::get('oldpassword')];
		if (!Auth::validate($credentials))
		{
			return Redirect::to('/login')->with('flash_message', 'You are not logged in. Please login to change your password');
		}
		elseif(Input::get('newpassword') !== Input::get('confirmnewpassword'))
		{
			return Redirect::to('/resetpassword')->with('flash_message', 'Passwords do not match.');
		}
		else
		{
			$employee=Employee::where('login','=',Auth::user()->login)->get()->first();
			$employee->password=Hash::make(Input::get('newpassword'));
			$employee->save();
			return Redirect::to('/employee/view/'.Auth::user()->id)
			->with('flash_message', 'Your password has been reset');;
		}
	}

}