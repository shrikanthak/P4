<?php


class EmployeeViewController extends BaseController {

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
		$employee=Employee::with('employee_portal')->with("position.department")->find($empid);
		$data=$this->GetEmplopyeeData($employee);

		return View::make('employeeview')->with('data',$data)->with('addEditForm',false);
	}
	public function viewOrgChart($empid)
	{
		$dataArray=$this->OrgChartData((integer)$empid);
		return View::make('orgchart')->with('dataArray',json_encode($dataArray));
	}

	private function GetEmplopyeeData($employee)
	{
		$data=array("current_id"=>$employee->id,
		"first_name"=>$employee->first_name,
		"last_name"=>$employee->last_name,
		"title"=>$employee->position->title,
		"department"=>(!!$employee->position->department)?$employee->position->department->name:'',
		"department_id"=>(!!$employee->position->department)?$employee->position->department->id:0,
		"supervisor"=>(!!$employee->supervisor)?$employee->supervisor->first_name." ".$employee->supervisor->last_name:'',
		"supervisor_id"=>(!!$employee->supervisor)?$employee->supervisor->id:0,
		"image"=>$employee->employee_portal->imagefile,
		"head_of_department"=>$employee->head_of_department,
		"paragraph"=>$employee->employee_portal->employee_info);

		return $data;
	}

	private function OrgChartData($id)
	{

		$rowArray=array();

		//Eager loading all employee data for org chart
		$employee=Employee::with('supervisor')->find($id);

		//supervisor of the employee. Going one level up
		if($employee->supervisor)
		{
			//reloading supervisor data with department and portal
			$supervisor=Employee::with('employee_portal')
								->with('position.department')
								->with('reportees')
								->find($employee->supervisor->id);
		
			$this->addSelf_Reportees($supervisor, $rowArray,$linkSupervisor=false);
		}
		else
		{
			$employee=Employee::with('employee_portal')
						->with('position.department')
						->with('supervisor')
						->with('reportees')
						->find($id);

			addSelf_Reportees($employee, $rowArray);
		}
		
		
		return $rowArray;
	}

	private function addSelf_Reportees(&$employee, &$rowArray,$linkSupervisor=true)
	{

		$rowArray[]=$this->createRow($employee, $linkSupervisor);
		foreach($employee->reportees as $reportee)
	    {
	      	$this->addSelf_Reportees($reportee, $rowArray);
	    }
	}	

	private function createRow(&$employee,$linksupervisor=true)
	{
			//retrieving employee portal and department of reportees
			$employee=Employee::with('employee_portal')->with('position.department')->find($employee->id);
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

	public function search()
	{
		$inputString=Input::get('search');
		echo $inputString;
	}

	public function showEmployeeBasicView()
	{
		$loginid=Input::get('search_content');
		
		$employee=Employee::with('employee_portal')
							->with("position.department")
							->where('login','=',$loginid)
							->get()->first();
		$data=$this->GetEmplopyeeData($employee);
		return View::make('employeebasicdataview')->with('data',$data)->with('addEditForm',true);;
	}
}
