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
		$empid=Input::get('_delete_employee_id');
		
		if($empid>0)
		{
			$employee=Employee::with('employee_portal')
								->with('position')->find($empid);
			$employee_portal=$employee->employee_portal;

			if($employee_portal->imagefile)
			{
				$filepath='./images';
				$filename=$employee->employee_portal->imagefile;

				if ($filename!=''? file_exists ($filepath.'/'.$filename) : false)
				{
					unlink ($filepath.'/'.$filename); 	
				}
			}
			
			if($employee->position)
			{
				$position=$employee->position;
				$position->employee_id=null;
				$position->open=true;
				$position->save();
			}
			
			$employee->delete();
			$employee_portal->delete();
			return('success');
		}
	}

	public function getOpenEmployeeList($includeemployee='')
	{
		$ids=Position::whereNotNull('employee_id')->lists('employee_id');

		if(!is_array($ids))
		{
			$ids=array($ids);
		}
		$employees=Employee::whereNotIn('id',$ids)->get();
		
		$employee_array=array(array('id'=>0,'description'=>'------------None---------------'));
		
		if($includeemployee!='')
		{
			$inc_employee=Employee::where('login','=',$includeemployee)->get()->first();
			$employee_array[]=array('id'=>$inc_employee->id,
				'description'=>$inc_employee->login.' ('.$inc_employee->first_name." ".$inc_employee->last_name.')');
		}

		foreach($employees as $employee)
		{
			
			$employee_array[]=array('id'=>$employee->id,
				'description'=>$employee->login.' ( '.$employee->first_name." ".$employee->last_name." ) ");
			
		}
		
		

		return json_encode($employee_array);
	}
}
