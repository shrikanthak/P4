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
			$table->string('password');
			$table->integer('position_id')->unsigned()->nullable();
			$table->integer('supervisor_id')->unsigned()->nullable();
			$table->integer('employee_portal_id')->unsigned()->nullable();
			$table->integer('group_id')->unsigned()->nullable();
			$table->timestamps();

			//setting up foreign key
			$table->foreign('group_id')->references('id')->on('groups');
			$table->foreign('supervisor_id')->references('id')->on('employees');
			$table->foreign('position_id')->references('id')->on('positions');
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
