<?php

use Paste\Pre;

class HRController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:

	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();		

	}

	public function hrAccess()
	{
		$loginArray=Employee::lists('login');
			Pre::render($loginArray,'Employee Logins');
			return View::make('hr')->with('loginArray',$loginArray)
				->with('departments',Department::getIdNamePair());
	}

	public function getPositionsTable()
	{
		$loginid=Input::get('search_content');
	}

	public function getPositionsEmployees()
	{
		$departmentid=(integer)Input::get('departmentid');


		if($departmentid==0)
		{
			return;
		}
		
		
		$positions=Position::with('department')
		->where('department_id','=',$departmentid)
		->where('open','=',true)->get();

		$posarray=array();
		
		foreach($positions as $position)
		{
			$posarray[]=array('id'=>$position->id,'description'=>$position->department->code.'-'.$position->title);
		}

		$department=Department::with('employees')->find($departmentid);
		$employees=$department->employees->all();
	
		$emparray=array();
		
		foreach($employees as $employee)
		{
			$emparray[]=array('id'=>$employee->id,'description'=>$employee->login);
		}
		
		$data=array('positions'=>$posarray,'employees'=>$emparray);
		
		return json_encode($data);
	}
}