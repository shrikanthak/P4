<?php

function seed_departments()
{
	DB::transaction( function()
	{
		//Seeding Departments
		$head=Department::create(array('name' => 'Company Head'));
		$finance=Department::create(array('name' => 'Finance & Accounting'));
		$marketing=Department::create(array('name' => 'Marketing & Sales'));
		$manufacturing=Department::create(array('name' => 'Manufacturing & Operations'));
		$procurement=Department::create(array('name' => 'Procurement'));
		$research=Department::create(array('name' => 'Research & Ddevelopment'));
		$it=Department::create(array('name' => 'Information Technology'));
		$hr=Department::create(array('name' => 'Human Resources'));
		$cs=Department::create(array('name' => 'Customer Support'));

	});

}

function seed_positions()
{
	DB::transaction(function()
	{
		$position=new Position();
		$position->title="Company President";
		$position->hr_access=true;
		$position->save();


		$position=new Position();
		$position->title="HR Manager";
		$position->hr_access=true;
		$position->save();

	});

}

function seed_employees()
{
	DB::transaction(function()
	{
		$employee=new Employee();
		$employee->first_name="Shrikanth";
		$employee->last_name="Ananthakrishnan";
		$employee->login="sananthakrishnan";
		$employee->password=Hash::make('halwa');
		$position=Position::where('title','=','Company President')->get()->first();
		$employee->position()->associate($position);
		
		$portal=new EmployeePortal();
		$portal->save();
		$employee->employee_portal()->associate($portal);

		$department=Department::where('name','=','Company Head')->get()->first();
		$employee->department()->associate($department);
		$employee->head_of_department=true;

		$employee->save();



		$employee=new Employee();
		$employee->first_name="John";
		$employee->last_name="Doe";
		$employee->login="jdoe";
		$employee->password=Hash::make('halwa');
		
		$position=Position::where('title','=','HR Manager')->get()->first();
		$employee->position()->associate($position);
		
		$positionBoss=Position::where('title','=','Company President')->get()->first();
		$employee->supervisor()->associate($positionBoss->employee);
		
		$portal=new EmployeePortal();
		$portal->save();
		$employee->employee_portal()->associate($portal);

		$department=Department::where('name','=','Human Resources')->get()->first();
		$employee->department()->associate($department);
		$employee->head_of_department=true;
		$employee->save();

	});

}
