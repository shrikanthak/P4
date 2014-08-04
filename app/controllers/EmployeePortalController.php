<?php


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
		$data=Employee::GetAllEmployeeData($empid)->get_data_array();

		return View::make('employeeview')->with('data',$data)->with('addEditForm',false);
	}
	public function viewOrgChart($empid)
	{
		$dataArray=$this->OrgChartData((integer)$empid);
		$employee=Employee::GetAllEmployeeData($empid);
		$data=$employee->get_data_array($employee);
		return View::make('orgchart')
		->with('dataArray',json_encode($dataArray))
		->with('data',$data)
		->with('addEditForm',false);
	}

	

	private function OrgChartData($id)
	{

		$rowArray=array();

		//Eager loading all employee data for org chart
		$employee=Employee::with('position.supervisor_position.employee')->find($id);

		//supervisor of the employee. Going one level up
		if((!!$employee->supervisor_position)?(!!$employee->supervisor_position->employee):false)
		{
			//reloading supervisor data with department and portal
			$supervisor=Employee::GetAllEmployeeDataEmployee($employee->position->supervisor->id);
		
			$this->addSelf_Reportees($supervisor, $rowArray,$linkSupervisor=false);
		}
		else
		{
			$this->addSelf_Reportees($employee, $rowArray);
		}
		
		
		return $rowArray;
	}

	private function addSelf_Reportees($employee, &$rowArray,$linkSupervisor=true)
	{

		$rowArray[]=$this->createRow($employee, $linkSupervisor);
		
		$reportees=$employee->reportees()->get();

		foreach($reportees as $reportee)
	    {
	      	$this->addSelf_Reportees($reportee, $rowArray);
	    }
	}	

	private function createRow(&$employee,$linksupervisor=true)
	{
			//retrieving employee portal and department of reportees
			$employee=Employee::with('employee_portal')
			->with('position.department')
			->with('position.supervisor_position')
			->find($employee->id);
			$htmlImageName=(!!$employee->employee_portal->imagefile) ? $employee->employee_portal->imagefile:'';

			$row=array(
					"id"=>$employee->id,
					"name"=>$employee->first_name." ".$employee->last_name,
					"title"=>$employee->position->title,
					"imagename"=>$htmlImageName,
					"supervisor_id"=>(($linksupervisor) && 	(!!$employee->position->supervisor_position)) ? 
							(string)$employee->position->supervisor_position->id:''
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

		$employee=Employee::where('login','=',$loginid)->get()->first();
		
		$employee=Employee::GetAllEmployeeData($employee->id);

		$data=$employee->get_data_array();
		return View::make('employeebasicdataview')->with('data',$data)->with('addEditForm',true);
	}
}
