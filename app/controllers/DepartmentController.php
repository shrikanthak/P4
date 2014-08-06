<?php

class DepartmentController extends BaseController
{

	public function __construct() 
	{

		# Make sure BaseController construct gets called
		parent::__construct();		

	}

	public function saveDepartment()
	{
		$department = Department::firstOrNew(array('code' => strtoupper(Input::get('department_code'))));
		$department->name=strtoupper(Input::get('department_name'));
		$department->code=strtoupper(Input::get('department_code'));
		if (Input::get('supervisor_position')>0)
		{
			$department->department_head_position_id=Input::get('supervisor_position');	
		}
		$department->save();
		return Redirect::to('hrpage');

	}
}