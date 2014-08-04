<?php

use Paste\Pre;

class EmployeePortalController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function __construct() {

		# Make sure BaseController construct gets called
		parent::__construct();		

	}

	public function viewEmployee($empid)
	{
		$data=EmployeePortalController::GetEmployeeViewData($empid);
		return View::make('employeeview')->with('data',$data)->with('addEditForm',false);
	}
	
	public function viewOrgChart($posid, $linktosupervisor=true)
	{
		$dataArray=$this->OrgChartData((integer)$posid,$linktosupervisor);
		$position=Position::with('employee')->find($posid);
		$data=EmployeePortalController::GetEmployeeViewData((!!$position->employee)? $position->employee->id:0);
		return View::make('orgchart')
		->with('dataArray',json_encode($dataArray))
		->with('data',$data)
		->with('addEditForm',false);
	}

	

	private function OrgChartData($posid, $linktosupervisor=true)
	{

		$rowArray=array();

		$position=Position::with('supervisor_position')->find($posid);

		//supervisor of the employee. Going one level up
		if(!!$position->supervisor_position && $linktosupervisor)
		{	
			$this->addSelf_Reportees($position->supervisor_position, $rowArray,$linkSupervisor=false);
		}
		else
		{
			$this->addSelf_Reportees($position, $rowArray,$linkSupervisor=false);
		}
		
		
		return $rowArray;
	}

	private function addSelf_Reportees($position, &$rowArray,$linkSupervisor=true)
	{
		$rowArray[]=$this->createRow($position, $linkSupervisor);
		
		$reportee_positions=$position->reportee_positions()->get();

		foreach($reportee_positions as $reportee_position)
	    {
	      	$this->addSelf_Reportees($reportee_position, $rowArray);
	    }
	}	

	private function createRow($position,$linksupervisor=true)
	{
		//retrieving employee portal and department of reportees

		$supervisor_position_collection=$position->supervisor_position()->get();

		$row=array(
				"id"=>$position->id,
				"title"=>$position->title,
				"supervisor_id"=>(($linksupervisor) && 	(!!$supervisor_position_collection[0])) ? 
						(string)$supervisor_position_collection[0]->id:''
				);

		$employee=Employee::with('employee_portal')->find($position->employee_id);

		if(!!$employee)
		{
			$row["name"]=$employee->first_name." ".$position->employee->last_name;
			$row["imagename"]=(!!$employee->employee_portal->imagefile) ? 
									$employee->employee_portal->imagefile:'';
		}
		else
		{
			$row["name"]='';
			$row["imagename"]='';
		}

		return $row;
	}

	public function saveEmployeePortal()
	{
		$employee=Employee::with('employee_portal')->find(Auth::user()->id);

		if(Input::has('employee_info'))
		{	
			$employee->employee_portal->employee_info=Input::get('employee_info');
		}
		$flash_message='';

		if(Input::hasFile('fileImageInput'))
		{
			if (getimagesize(Input::file('fileImageInput')->getRealPath()))
			{
				$filename=$employee->employee_portal->imagefile;

				$name=uniqid().".".Input::file('fileImageInput')->guessExtension();
				
				$filepath='./images';

				if ($filename!=''? file_exists ($filepath.'/'.$filename) : false)
				{
					unlink ($filepath.'/'.$filename); 	
				}
				Input::file('fileImageInput')->move($filepath, $name);

				$employee->employee_portal->imagefile=$name;
			}
			else
			{
				$flash_message="File uploaded is not an image file";
			}
		}
		
		$employee->push();

		if ($flash_message!='')
		{
			return Redirect::to('employee/view/'.Auth::user()->id)->with('flash_message',$flash_message);
		}
		else
		{
			return Redirect::to('employee/view/'.Auth::user()->id);
		}
		
	}

	public function search($input)
	{
		$inputString=$input;
		
		//Search for Departments
		$departments=Department::with('department_head.employee')
								->where('name','like','%'.$inputString.'%')
								->orWhere('code','like','%'.$inputString.'%')
								->get();

		$employee_ids=Employee::where('first_name','like','%'.$inputString.'%')
							->orWhere('last_name','like','%'.$inputString.'%')
							->orWhere('login','like','%'.$inputString.'%')->distinct()->lists('id');

		return View::make('searchresults')->with('employee_ids',$employee_ids)->with('departments',$departments);

	}

	public function showEmployeeBasicView($loginid)
	{

		$data=EmployeePortalController::GetEmployeeViewData(Employee::where('login','=',$loginid)->pluck('id'));
		return View::make('employeebasicdataview')->with('data',$data)->with('addEditForm',true);
	}

	public static function GetEmployeeViewData($empid)
	{
		$employee=Employee::with('employee_portal')
							->with('position')
							->find($empid);
		$data=Employee::GetDataArray($employee);
		$position=null;
		if (($employee) && ($employee->position))
		{
			$position=Position::with('department')
				->with('supervisor_position.employee')
				->with('department_head_of')
				->find($employee->position->id);
		}
		//echo print_r((Position::GetDataArray($position)));
		//dd();

		return array_merge($data,Position::GetDataArray($position));
	}

	public function viewDepartment($depid)
	{
		$department=Department::with('department_head')->find($depid);
		if(!!$department->department_head)
		{
			return $this->viewOrgChart($department->department_head->id, $linktosupervisor=false);
		}
	}
}
