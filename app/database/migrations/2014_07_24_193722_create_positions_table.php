<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('positions',function($table)
		{	
			$table->increments('id');
			$table->string('title')->nullable(false);
			$table->boolean('hr_access')->default(false);
			$table->boolean('open')->default(true);
			$table->integer('department_id')->unsigned()->nullable(false);
			$table->timestamps();

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
		//
		//
		Schema::drop('positions');
	}

}
