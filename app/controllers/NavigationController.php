<?php

class NavigationController extends BaseController
{
	
	public function __construct() 
	{

		# Make sure BaseController construct gets called
		parent::__construct();		

	}

	public function showWelcome()
	{
		return View::make('welcome');
	}

	//route for HR Access Page
	public function getHRPage()
	{
		$loginArray=Employee::lists('login');

		$departments_list=array();

		$departments = Department::with('department_head')->with('positions')->get();	

		foreach($departments as $department) {
			$positions_list[$department->id] = $department->name;
		}	
		
		foreach($departments as $department) {
			$departments_list[$department->id] = $department->name;
		}	

		return View::make('hr')->with('loginArray',$loginArray)
				->with('departments_list',$departments_list)
				->with('departments',$departments);
	}
}