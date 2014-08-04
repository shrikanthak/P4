<?php

class EmployeeController extends BaseController
{

	public function __construct() 
	{

		# Make sure BaseController construct gets called
		parent::__construct();		

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

			$employee->first_name=strtoupper(Input::get('first_name'));
			$employee->last_name=strtoupper(Input::get('last_name'));
			
	
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
			
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$employee->save();
		}

		return Redirect::route("basicviewroute",array('login'=>$employee->login));
	}
	public function deleteEmployee()
	{
		return "employee deleted";
	}

	public function getOpenEmployeeList()
	{
		$ids=Position::whereNotNull('employee_id')->lists('employee_id');
		if(!is_array($ids))
		{
			$ids=array($ids);
		}
		$employees=Employee::whereNotIn('id',$ids)->get();
		
		$employee_array=array(array('id'=>0,'description'=>'------------None---------------'));
		
		foreach($employees as $employee)
		{
			
			$employee_array[]=array('id'=>$employee->id,
				'description'=>$employee->login.' ( '.$employee->first_name." ".$employee->last_name." ) ");
			
		}
		return json_encode($employee_array);
	}
}
