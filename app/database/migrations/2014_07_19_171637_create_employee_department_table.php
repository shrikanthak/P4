<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDepartmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('employee_department',function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('employee_id');
			$table->integer('department_id');
			$table->integer('supervisor_id');
			$table->string('title');
			$table->integer('group_id');
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
		Schema::drop('employee_department');
	}

}
