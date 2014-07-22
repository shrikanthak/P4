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

//Route for employee to view his data
Route::get('employee/view/', function()
	{
		$paragraph="Eget lectus proin vivamus donec nullam placerat a lorem, senectus enim non consequat cras litora. Facilisis praesent tellus curabitur scelerisque proin potenti metus purus accumsan eu sodales eros, ultricies urna donec proin potenti nibh ipsum commodo fermentum leo. Porttitor ultrices aliquam erat sodales lorem purus cubilia leo morbi nullam, habitasse nibh class sapien pharetra cursus vel per morbi. Tempus faucibus litora facilisis volutpat elit netus auctor per, lacinia rutrum ullamcorper ad lacinia non molestie massa, lorem nam consectetur congue dolor litora sit. Id auctor cras quisque placerat convallis scelerisque taciti, scelerisque viverra fames donec pretium sagittis nullam et, suspendisse litora torquent dictum congue nullam.";
		
		$data=array(
			"first_name"=>"Shrikanth",
			"last_name"=>"Ananthakrishnan",
			"title"=>"Software Engineer",
			"department"=>"PDM",
			"supervisor"=>"Chris Ryan",
			"image"=>"ShriAnan.jpg");

			
		return View::make('employeeview')->with('paragraph',$paragraph)->with('bView',true)->with('data',$data);

	});

//-------------------------------------------

