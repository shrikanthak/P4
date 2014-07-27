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

Route::post('/authenticate', array('before' => 'csrf',
	
	function() 
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
  ));


//This function is called to make login
Route::get('/login',function()
	{
		return View::make('login');

	});

//This function is called to make login
Route::get('/logout',function()
	{
		Auth::logout();
		return View::make('welcome');

	});

//Route for searhing based on search string input by the user
Route::get('/search', function()
	{
		$inputString=Input::get('txtSearch');
		echo $inputString;
		return View::make('orgchart');
	});

//Route for employee to view his data
Route::get('employee/view/{empid}', array('before' => 'auth',function($empid)
{
	
	$employee=Employee::with('employee_portal')->with("position")->with("group.department")->find($$empid);

	$data=array(
	"current_id"=>$empid,
	"first_name"=>$employee->first_name,
	"last_name"=>$employee->last_name,
	"title"=>$employee->position->title,
	"department"=>(!!$employee->group->department)?$employee->group->department->name:'',
	"group"=>$employee->group->name,
	"supervisor"=>(!!$employee->supervisor)?$employee->supervisor->first_name." ".$employee->supervisor->last_name:'',
	"supervisor_id"=>(!!$employee->supervisor)?$employee->supervisor->id:0,
	"image"=>$employee->employee_portal->imagefile,
	"paragraph"=>$employee->employee_portal->employee_info);

	return View::make('employeeview')->with('data',$data);
	

}));

Route::post('employee/save', array('before' => 'csrf|auth',
	function()
	{
		$employee=Employee::with('employee_portal')->find(Auth::user()->id);

		if(Input::has('employee_info'))
		{	
			$employee->employee_portal->employee_info=Input::get('employee_info');
		}
		$flash_message='';

		if(Input::hasFile('fileImageInput'))
		{
			if (getimagesize(Input::file('fileImageInput')->getRealPath()))
			{
				$filename=$employee->employee_portal->imagefile;

				$name=uniqid().".".Input::file('fileImageInput')->guessExtension();
				
				$filepath='./images';

				if ($filename!=''? file_exists ($filepath.'/'.$filename) : false)
				{
					unlink ($filepath.'/'.$filename); 	
				}
				Input::file('fileImageInput')->move($filepath, $name);

				$employee->employee_portal->imagefile=$name;
			}
			else
			{
				$flash_message="File uploaded is not an image file";
			}
		}
		
		$employee->push();

		if ($flash_message!='')
		{
			return Redirect::to('employee/view')->with('flash_message',$flash_message);
		}
		else
		{
			return Redirect::to('employee/view');
		}
		
	}
));

//seeding the database
Route::get('/dbseeder',function(){

	DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
	DB::statement('TRUNCATE employee_expertise');
	DB::statement('TRUNCATE expertise');
	DB::statement('TRUNCATE employees');
	DB::statement('TRUNCATE employee_portals');
	DB::statement('TRUNCATE groups');
	DB::statement('TRUNCATE departments');
	DB::statement('TRUNCATE positions');
	DB::statement('SET FOREIGN_KEY_CHECKS=1');
	
	require 'dbseeder.php';
	
	seed_departments();
	seed_positions();
	seed_employees();

});

//Debug function to view database connection info
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