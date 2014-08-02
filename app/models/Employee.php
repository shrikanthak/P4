<?php

class Employee extends Eloquent
{
	protected $table = 'employees';

	
	public function employee_portal()
	{
		return $this->belongsTo('EmployeePortal','employee_portal_id');
	}
	
	public function expertise()
	{
		return $this->belongsToMany('Expertise','employee_expertise','employee_id','expertise_id');
	}

	public function position()
	{
		return $this->belongsTo('Position','position_id');
	}

	public function reportees()
	{
		return $this->hasManyThrough('Employee','Position','supervisor_position_id','id');
	}

	public function get_data_array()
	{
		$data=array("current_id"=>$this->id,
		"first_name"=>$this->first_name,
		"last_name"=>$this->last_name,
		"title"=>$this->position->title,
		"department"=>(!!$this->position->department)?$this->position->department->name:'',
		"department_id"=>(!!$this->position->department)?$this->position->department->id:0,
		"supervisor"=>(!!$this->position->supervisor_position) ? ((!!$this->position->supervisor_position->employee)? 
						$this->position->supervisor_position->employee->first_name." "
						.$this->position->supervisor_position->employee->last_name:''):'',
		"supervisor_id"=>(!!$this->position->supervisor_position)?((!!$this->position->supervisor_position->employee)?
							$this->position->supervisor_position->employee->id:0):'',
		"image"=>(!!$this->employee_portal->imagefile) ? $this->employee_portal->imagefile:"",
		"head_of_department"=>(!!$this->position->department_head_of) ? $this->department_head_of->name:'',
		"paragraph"=>$this->employee_portal->employee_info,
		"position_id"=>(!!$this->position)?$this->position->id:0,
		"login"=>$this->login,);

		return $data;
	}

	public static function GetAllEmployeeData($empid)
	{
		$employee=Employee::with('employee_portal')
		->with("position.department.department_head")
		->with("position.supervisor_position.employee")
		->with("position.department_head_of")->find($empid);

		return $employee;
	}


}



