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
			$table->string('name')->nullable(false);
			$table->string('code')->nullable(false)->unique();
			$table->boolean('corporate_head')->default(false);
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
		schema::drop('departments');
	}

}
