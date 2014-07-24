<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//departments table

		Schema::create('departments',function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();

		});

		//groups table
		Schema::create('groups',function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('department_id')->unsigned();
			$table->timestamps();

			//setting up foreign key
			$table->foreign('department_id')->references('id')->on('departments');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		schema::drop('groups');
		schema::drop('departments');
		
	}

}
