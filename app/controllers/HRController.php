<?php

class HRController extends BaseController 
{

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

	public function __construct() 
	{

		# Make sure BaseController construct gets called
		parent::__construct();		

	}


	public function getPositionsTable()
	{
		$loginid=Input::get('search_content');
	}

	public function getOpenPositions($depid,$empid=0)
	{
		$positions=Position::where('department_id','=',$depid)
		->where('open','=',true)->get();

		$posarray=array();
		$posarray=array(array('id'=>0,'description'=>'------------None---------------'));
		if ($empid>0)
		{
			$employee=Employee::with('position.department')->find($empid);
			$posarray[]=array('id'=>$employee->position->id,'description'=>$employee->position->department->code.'-'.$employee->position->title.": ".$employee->position->title);

		}
		foreach($positions as $position)
		{
			$posarray[]=array('id'=>$position->id,'description'=>$position->department->code.'-'.$position->title.": ".$position->title);
		}
		
		return json_encode($posarray);
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

			$position=Position::find($employee->position_id);
			$position->open=true;
			$position->save();


			if(Input::get("employee_position")>0)
			{
				$position=Position::find(Input::get("employee_position"));
				if($position)
				{
					$position->open=false;
					$position->save();
					$employee->position()->associate($position);
					
				}

			}
			else
			{
				$employee->position_id=0;
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
					$position->save();
					$employee->position()->associate($position);
					
				}

			}
			
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$employee->save();
		}

		$url=URL::route('basicviewroute');
		return Redirect::to($url."/".$employee->login);
	}

	//route for HR Access Page
	public function getHRPage()
	{
		$loginArray=Employee::lists('login');
		
		return View::make('hr')->with('loginArray',$loginArray)
				->with('departments',Department::getIdNamePair());
	}
}