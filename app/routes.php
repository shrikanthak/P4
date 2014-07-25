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

Route::post('/login', array('before' => 'csrf',
	
	function() 
	{
		if (Auth::attempt(array('login'=>Input::only('login'), 'login'=>Input::only('password')), $remember = false)) 
		{
		    return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
		}
		else 
		{
		    return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
		}

		return Redirect::to('login');
	}
  ));



//This function is called to make login
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
	if (Session::has('id'))
	{


		$id=Session::get('id');

		$paragraph="Eget lectus proin vivamus donec nullam placerat a lorem, senectus enim non consequat cras litora. Facilisis praesent tellus curabitur scelerisque proin potenti metus purus accumsan eu sodales eros, ultricies urna donec proin potenti nibh ipsum commodo fermentum leo. Porttitor ultrices aliquam erat sodales lorem purus cubilia leo morbi nullam, habitasse nibh class sapien pharetra cursus vel per morbi. Tempus faucibus litora facilisis volutpat elit netus auctor per, lacinia rutrum ullamcorper ad lacinia non molestie massa, lorem nam consectetur congue dolor litora sit. Id auctor cras quisque placerat convallis scelerisque taciti, scelerisque viverra fames donec pretium sagittis nullam et, suspendisse litora torquent dictum congue nullam.";

		$data=array(
		"first_name"=>"Shrikanth",
		"last_name"=>"Ananthakrishnan",
		"title"=>"Software Engineer",
		"department"=>"PDM",
		"group"=>"",
		"supervisor"=>"Chris Ryan",
		"image"=>"ShriAnan.jpg");


		return View::make('employeeview')->with('paragraph',$paragraph)->with('bView',true)->with('data',$data);
	}

});

//-------------------------------------------

//Route for employee to edit his data
Route::get('employee/edit/', function()
{
	$paragraph="Eget lectus proin vivamus donec nullam placerat a lorem, senectus enim non consequat cras litora. Facilisis praesent tellus curabitur scelerisque proin potenti metus purus accumsan eu sodales eros, ultricies urna donec proin potenti nibh ipsum commodo fermentum leo. Porttitor ultrices aliquam erat sodales lorem purus cubilia leo morbi nullam, habitasse nibh class sapien pharetra cursus vel per morbi. Tempus faucibus litora facilisis volutpat elit netus auctor per, lacinia rutrum ullamcorper ad lacinia non molestie massa, lorem nam consectetur congue dolor litora sit. Id auctor cras quisque placerat convallis scelerisque taciti, scelerisque viverra fames donec pretium sagittis nullam et, suspendisse litora torquent dictum congue nullam.";
	$data=array(
			"first_name"=>"Shrikanth",
			"last_name"=>"Ananthakrishnan",
			"title"=>"Software Engineer",
			"department"=>"PDM",
			"supervisor"=>"Chris Ryan",
			"image"=>"ShriAnan.jpg");
	return View::make('employeeview')->with('paragraph',$paragraph)->with('bView',false)->with('data',$data);
});

Route::get('employee/edit/', function()
{
	$paragraph="Eget lectus proin vivamus donec nullam placerat a lorem, senectus enim non consequat cras litora. Facilisis praesent tellus curabitur scelerisque proin potenti metus purus accumsan eu sodales eros, ultricies urna donec proin potenti nibh ipsum commodo fermentum leo. Porttitor ultrices aliquam erat sodales lorem purus cubilia leo morbi nullam, habitasse nibh class sapien pharetra cursus vel per morbi. Tempus faucibus litora facilisis volutpat elit netus auctor per, lacinia rutrum ullamcorper ad lacinia non molestie massa, lorem nam consectetur congue dolor litora sit. Id auctor cras quisque placerat convallis scelerisque taciti, scelerisque viverra fames donec pretium sagittis nullam et, suspendisse litora torquent dictum congue nullam.";
	$data=array(
			"first_name"=>"Shrikanth",
			"last_name"=>"Ananthakrishnan",
			"title"=>"Software Engineer",
			"department"=>"PDM",
			"supervisor"=>"Chris Ryan",
			"image"=>"ShriAnan.jpg");
	return View::make('employeeview')->with('paragraph',$paragraph)->with('bView',false)->with('data',$data);
});

//seeding the database
Route::get('/seeddb',function(){



});

Route::get('/debug',function()
{
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