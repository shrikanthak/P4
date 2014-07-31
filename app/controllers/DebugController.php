<?php

class DebugController extends BaseController 
{
	
	
	public function testdatabase()
	{
		echo '<pre>';

	    echo '<h1>environment.php</h1>';
	    $path   = base_path().'/environment.php';

	    try {
	        $contents = 'Contents: '.File::getRequire($path);
	        $exists = 'Yes';
	    }
	    catch (Exception $e) {
	        $exists = 'No. Defaulting to `production`';
	        $contents = '';
	    }

	    echo "Checking for: ".$path.'<br>';
	    echo 'Exists: '.$exists.'<br>';
	    echo $contents;
	    echo '<br>';

	    echo '<h1>Environment</h1>';
	    echo App::environment().'</h1>';

	    echo '<h1>Debugging?</h1>';
	    if(Config::get('app.debug')) echo "Yes"; else echo "No";

	    echo '<h1>Database Config</h1>';
	    print_r(Config::get('database.connections.mysql'));

	    echo '<h1>Test Database Connection</h1>';
	    try {
	        $results = DB::select('SHOW DATABASES;');
	        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
	        echo "<br><br>Your Databases:<br><br>";
	        print_r($results);
	    } 
	    catch (Exception $e) {
	        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
	    }

	    echo '</pre>';
	}
	
	public function dbseeder()
	{

		DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
		DB::statement('TRUNCATE employee_expertise');
		DB::statement('TRUNCATE expertise');
		DB::statement('TRUNCATE employees');
		DB::statement('TRUNCATE employee_portals');
		DB::statement('TRUNCATE departments');
		DB::statement('TRUNCATE positions');
		DB::statement('SET FOREIGN_KEY_CHECKS=1');
		
		$this->seed_departments();
		$this->seed_positions();
		$this->seed_employees();

	}


	private function seed_departments()
	{
		DB::transaction( function()
		{
			//Seeding Departments

			$head=Department::create(array('name' => 'Corporate Head', 'code'=>'COR'));
			$finance=Department::create(array('name' => 'Finance & Accounting', 'code'=>'FIN'));
			$marketing=Department::create(array('name' => 'Marketing & Sales','code'=>'MAR'));
			$manufacturing=Department::create(array('name' => 'Manufacturing & Operations','code'=>'MNO'));
			$procurement=Department::create(array('name' => 'Procurement','code'=>'PUR'));
			$research=Department::create(array('name' => 'Research & Ddevelopment','code'=>'RND'));
			$it=Department::create(array('name' => 'Information Technology','code'=>'IT'));
			$hr=Department::create(array('name' => 'Human Resources','code'=>'HR'));
			$cs=Department::create(array('name' => 'Customer Support','code'=>'CUS'));

		});

	}

	private function seed_positions()
	{
		DB::transaction(function()
		{
			$position=new Position();
			$position->title="Company President";
			$position->hr_access=true;
			$position->open=false;
			$department=Department::where('code','=','COR')->get()->first();
			$position->department()->associate($department);
			$position->save();


			$position=new Position();
			$position->title="HR Manager";
			$position->hr_access=true;
			$position->open=false;
			$department=Department::where('code','=','HR')->get()->first();
			$position->department()->associate($department);
			$position->save();

			$position=new Position();
			$position->title="Recruitment Manager";
			$position->hr_access=true;
			$position->open=false;
			$department=Department::where('code','=','HR')->get()->first();
			$position->department()->associate($department);
			$position->save();

			$position=new Position();
			$position->title="Chief Financial Officer";
			$position->hr_access=false;
			$position->open=false;
			$department=Department::where('code','=','FIN')->get()->first();
			$position->department()->associate($department);
			$position->save();
			
			$position=new Position();
			$position->title="Operations Manager";
			$position->hr_access=false;
			$position->open=false;
			$department=Department::where('code','=','MNO')->get()->first();
			$position->department()->associate($department);
			$position->save();
			
			$position=new Position();
			$position->title="HR Officer Recruitment";
			$position->hr_access=false;
			$position->open=false;
			$department=Department::where('code','=','HR')->get()->first();
			$position->department()->associate($department);
			$position->save();

			$position=new Position();
			$position->title="Auditor";
			$position->hr_access=false;
			$position->open=false;
			$department=Department::where('code','=','FIN')->get()->first();
			$position->department()->associate($department);
			$position->save();

			$position=new Position();
			$position->title="Accountant";
			$position->hr_access=false;
			$position->open=true;
			$department=Department::where('code','=','FIN')->get()->first();
			$position->department()->associate($department);
			$position->save();

		});

	}

	private function seed_employees()
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
			$employee->head_of_department=true;
			$employee->save();



			$employee=new Employee();
			$employee->first_name="John";
			$employee->last_name="Doe";
			$employee->login="jdoe";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','HR Manager')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','Company President')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=true;
			$employee->save();


			$employee=new Employee();
			$employee->first_name="Jenny";
			$employee->last_name="Dane";
			$employee->login="jdane";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','Recruitment Manager')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','HR Manager')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=false;
			$employee->save();


			$employee=new Employee();
			$employee->first_name="Happy";
			$employee->last_name="Honey";
			$employee->login="hhoney";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','HR Officer Recruitment')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','Recruitment Manager')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=false;
			$employee->save();


			$employee=new Employee();
			$employee->first_name="Billy";
			$employee->last_name="Boy";
			$employee->login="bboy";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','Operations Manager')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','Company President')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=true;
			$employee->save();


			$employee=new Employee();
			$employee->first_name="Free";
			$employee->last_name="Willy";
			$employee->login="fwilly";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','Chief Financial Officer')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','Company President')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=true;
			$employee->save();

			$employee=new Employee();
			$employee->first_name="Freddy";
			$employee->last_name="Teddy";
			$employee->login="fteddy";
			$employee->password=Hash::make('halwa');
			$position=Position::where('title','=','Auditor')->get()->first();
			$employee->position()->associate($position);
			$portal=new EmployeePortal();
			$portal->save();
			$employee->employee_portal()->associate($portal);
			$positionBoss=Position::where('title','=','Chief Financial Officer')->get()->first();
			$employee->supervisor()->associate($positionBoss->employee);
			$employee->head_of_department=true;
			$employee->save();

		});
	}
	
	public function test()
	{
		$department=Department::with('employees')->where('id','=',2)->get()->first();
		$employees=$department->employees->all();
		echo print_r($employees);
	}

	
}

