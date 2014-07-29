<?php

function GetEmplopyeeData($employee)
{
	$data=array("current_id"=>$employee->empid,
	"first_name"=>$employee->first_name,
	"last_name"=>$employee->last_name,
	"title"=>$employee->position->title,
	"department"=>(!!$employee->department)?$employee->department->name:'',
	"department_id"=>(!!$employee->department)?$employee->department->id:0,
	"supervisor"=>(!!$employee->supervisor)?$employee->supervisor->first_name." ".$employee->supervisor->last_name:'',
	"supervisor_id"=>(!!$employee->supervisor)?$employee->supervisor->id:0,
	"image"=>$employee->employee_portal->imagefile,
	"head_of_department"=>$employee->head_of_department,
	"paragraph"=>$employee->employee_portal->employee_info);

	return $data;
}