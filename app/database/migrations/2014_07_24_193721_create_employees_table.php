<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees',function($table)
		{	
			//setting up columns
			$table->increments('id');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('login')->unique()->nullable(false);
			$table->string('password')->nullable(false);
			$table->integer('employee_portal_id')->unsigned()->nullable();
			$table->timestamps();

			//setting up foreign key
			$table->foreign('employee_portal_id')->references('id')->on('employee_portals');



		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('employees');
	}

}
