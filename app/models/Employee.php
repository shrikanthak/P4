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

	public function supervisor()
	{
		return $this->belongsTo('Employee','supervisor_id');
	}

	public function reportees()
	{
		return $this->hasMany('Employee','supervisor_id');
	}

	public function get_data()
	{
		$data=array("current_id"=>$this->id,
		"first_name"=>$this->first_name,
		"last_name"=>$this->last_name,
		"title"=>$this->position->title,
		"department"=>(!!$this->position->department)?$this->position->department->name:'',
		"department_id"=>(!!$this->position->department)?$this->position->department->id:0,
		"supervisor"=>(!!$this->supervisor)?$this->supervisor->first_name." ".$this->supervisor->last_name:'',
		"supervisor_id"=>(!!$this->supervisor)?$this->supervisor->id:0,
		"image"=>(!!$this->employee_portal->imagefile) ? $this->employee_portal->imagefile:"",
		"head_of_department"=>$this->head_of_department,
		"paragraph"=>$this->employee_portal->employee_info,
		"position_id"=>(!!$this->position)?$this->position->id:0,
		"login"=>$this->login,);

		return $data;
	}
}



