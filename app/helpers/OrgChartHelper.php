<?php

use Paste\Pre;
function OrgChartData($id)
{

	$rowArray=array();

	//Eager loading all employee data for org chart
	$employee=Employee::with('department')
					->with('employee_portal')
					->with('position')
					->with('supervisor')
					->with('reportees')
					->find($id);

	//supervisor of the employee. Going one level up
	if($employee->supervisor)
	{
		//reloading supervisor data with department and portal
		$supervisor=Employee::with('department')->with('employee_portal')->find($employee->supervisor->id);
	
		if(!!$supervisor)
		{
			$rowArray[]=createRow($supervisor,false);
			
		}
	}
	
	addSelf_Reportees($employee, $rowArray);
	return $rowArray;
}

function addSelf_Reportees(&$employee, &$rowArray)
{
	$rowArray[]=createRow($employee);
	foreach($employee->reportees as $reportee)
    {
      	addSelf_Reportees($reportee, $rowArray);
    }
	

}

function createRow(&$employee,$linksupervisor=true)
{
		//retrieving employee portal and department of reportees
		$employee=Employee::with('employee_portal')->with('department')->find($employee->id);
		$htmlImageName=(!!$employee->employee_portal->imagefile) ? $employee->employee_portal->imagefile:'';

		$row=array(
				"id"=>$employee->id,
				"name"=>$employee->first_name." ".$employee->last_name,
				"title"=>$employee->position->title,
				"imagename"=>$htmlImageName,
				"supervisor_id"=>(($linksupervisor) && (!!$employee->supervisor)) ? (string)$employee->supervisor->id:''
				);
		return $row;
}