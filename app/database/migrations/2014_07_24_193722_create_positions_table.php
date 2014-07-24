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
			$table->integer('group_id')->unsigned();
			$table->boolean('hr_access')->default(false);
			$table->timestamps();

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
