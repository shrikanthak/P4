<?php

function seed_departments()
{
	DB::transaction( function()
	{
		//Seeding Departments
		$head=Department::create(array('name' => 'Company Heads'));
		$finance=Department::create(array('name' => 'Finance & Accounting'));
		$marketing=Department::create(array('name' => 'Marketing & Sales'));
		$manufacturing=Department::create(array('name' => 'Manufacturing & Operations'));
		$procurement=Department::create(array('name' => 'Procurement'));
		$research=Department::create(array('name' => 'Research & Ddevelopment'));
		$it=Department::create(array('name' => 'Information Technology'));
		$hr=Department::create(array('name' => 'Human Resources'));
		$cs=Department::create(array('name' => 'Customer Support'));

		//seeding groups finamce
		$group=new Group;
		$group->name="Company Head";
		$group->department()->associate($head);
		$group->save();

		$group=new Group;
		$group->name="Audit";
		$group->department()->associate($finance);
		$group->save();

		$group=new Group;
		$group->name="Accounting";
		$group->department()->associate($finance);
		$group->save();

		$group=new Group;
		$group->name="Receivables";
		$group->department()->associate($finance);
		$group->save();

		$group=new Group;
		$group->name="Payments";
		$group->department()->associate($finance);
		$group->save();

		
		//seeding groups marketing
		$group=new Group;
		$group->name="Online Marketing";
		$group->department()->associate($marketing);
		$group->save();

		$group=new Group;
		$group->name="Direct Marketing";
		$group->department()->associate($marketing);
		$group->save();

		$group=new Group;
		$group->name="Online Sales";
		$group->department()->associate($marketing);
		$group->save();

		$group=new Group;
		$group->name="Direct Sales";
		$group->department()->associate($marketing);
		$group->save();

		$group=new Group;
		$group->name="HR Management";
		$group->department()->associate($hr);
		$group->save();


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

		$group=Group::where('name','=','Company Head')->get()->first();
		$employee->group()->associate($group);

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

		$group=Group::where('name','=','HR Management')->get()->first();
		$employee->group()->associate($group);

		$employee->save();

	});

}
