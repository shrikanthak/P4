<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePortalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_portal',function($table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->integer('employee_id');
			$table->string('imagefile');
			$table->text('biography');
			$table->text('interests');
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
		Schema::drop('employee_portal');
	}

}
