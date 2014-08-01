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

//route for HR Access Page
	public function hraccess()
	{
		return "in HR Access Page";
		dd();
		$loginArray=Employee::lists('login');
			Pre::render($loginArray,'Employee Logins');
			return View::make('hr')->with('loginArray',$loginArray)
				->with('departments',Department::getIdNamePair());
	}

	public function getPositionsTable()
	{
		$loginid=Input::get('search_content');
	}

	public function getPositionsEmployees($empid)
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
		$posarray=array(array('id'=>0,'description'=>'------------None---------------'));

		foreach($positions as $position)
		{
			$posarray[]=array('id'=>$position->id,'description'=>$position->department->code.'-'.$position->title);
		}

		$department=Department::with('employees')->find($departmentid);
		
		$employees=$department->employees->all();
		if ($empid>0)
		{
			$emp=$employees->fetch($empid);
			removeReportees($emp, $employees);
			$employees->forget($empid);
		}
		
	
		$emparray=array(array('id'=>0,'description'=>'------------None---------------'));
		
		foreach($employees as $employee)
		{
			$emparray[]=array('id'=>$employee->id,'description'=>$employee->first_name." ".
			$employee->last_name." (".$employee->login.")");
		}
		
		$data=array('positions'=>$posarray,'employees'=>$emparray);
		
		return json_encode($data);
	}

	private function removeReportees($emp, &$empCollection)
	{
		$reportees=$emp->reportees()->all();

		foreach ($reportee as $reportees)
		{
			removeReportees($emp, &$empCollection);
			$employees->forget($reportee->id);
		}
	}

	public function saveEmployee()
	{
	
		if(Input::get('_employee_id')>0)
		{
			$employee=Employee::find(Input::get('_employee_id'));
			if(!$employee)
			{
				return "Error: Employee does not exist";
			}

			$position=Position::find($employee->position_id)
			$position->open=true;
			$position->save();


			if(Input::get("employee_position")>0)
			{
				$position=Position::find(Input::get("employee_position"));
				if($position)
				{
					$position->open=false;
					$employee->position()->associate($position);
					$position->save();
				}

			}
			else
			{
				$employee->position_id=0;
			}
			
			if(Input::get("employee_supervisor")>0)
			{
				$employee->supervisor_id=Input::get("employee_supervisor");
			}
			else
			{
				$employee->supervisor_id=0;
			}
	
			$employee->save();
		}
		else
		{
			$employee=new Employee();
			$employee->first_name=strtoupper(Input::get('first_name'));
			$employee->last_name=strtoupper(Input::get('last_name'));

			//login must be unique, hence add a number to the end if the user exists
			$login=substr(strtolower(Input::get('first_name')),0,1).strtolower(Input::get('last_name'));
			
			$employee_exists=Employee::where('login','=',$login)->get();

			$i=0;
			
			if(!$employee_exists->isEmpty())
			{
				for($i=1;;$i++)
				{
					$employee_exists=Employee::where('login','=',$login.$i)->get();
					if($employee_exists->isEmpty())
					{
						break;
					}
				}
			}
			
			$employee->login=($i==0)?$login:$login.$i;

			$employee->password=Hash::make('halwa');
	
			if(Input::get("employee_position")>0)
			{
				$position=Position::find(Input::get("employee_position"));
				if($position)
				{
					$position->open=false;
					$employee->position()->associate($position);
					$position->save();
				}

			}
			
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
	
			if(Input::get("employee_supervisor")>0)
			{
				$employee->supervisor_id=Input::get("employee_supervisor");
			}
			$employee->save();
		}

		$url=URL::route('basicviewroute');
		return Redirect::to($url."/".$employee->login);
	}
}