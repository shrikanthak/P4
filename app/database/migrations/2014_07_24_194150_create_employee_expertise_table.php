<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeExpertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('employee_expertise',function($table)
		{	
			//setting up columns
			$table->integer('employee_id')->unsigned();
			$table->integer('expertise_id')->unsigned();
			$table->timestamps();


			//defining foreign keys
			$table->foreign('employee_id')->references('id')->on('employees');
			$table->foreign('expertise_id')->references('id')->on('expertise');
			$table->primary(array('employee_id', 'expertise_id'));

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
		Schema::drop('employee_expertise');
	}

}
