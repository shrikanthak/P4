<?php

function seed_departments()
{
	DB::transaction( function()
	{
		//Seeding Departments
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

	});

}

function seed_positions()
{
	DB::transaction(function()
	{
		
	});

}
