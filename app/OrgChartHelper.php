<?php

use Paste\Pre;
function OrgChartData($id)
{

	$rowArray=array();
	$employee=Employee::with('department')->with('employee_portal')->with('position')->find($id);

	//supervisor of the employee. Going one level up to navigate the tree
	if($employee->supervisor)
	{
		$supervisor=Employee::with('department')->with('employee_portal')->find($employee->supervisor->id);
	
		if(!!$supervisor)
		{
			$rowArray[0]=createRow($supervisor,false);
			
		}
	}
	
	addSelf_Reportees($employee, $rowArray);
	
	echo Pre::render($rowArray);

	return $rowArray;
}

function addSelf_Reportees(&$employee, &$rowArray)
{
	$rowArray[]=createRow($employee);

	$employee->reportees->each(function($reportee)
    {
    	
    	addSelf_Reportees($reportee, $rowArray);
    });
    //dd();
	/*$reportees=$ReporteesCollection->toArray();
	foreach ($reportees as $reportee)
    {
    	array_push($rowArray,createRow($reportee));
    	addSelf_Reportees($reportee, $rowArray);
    }*/
	

}

function createRow(&$employee,$linksupervisor=true)
{
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