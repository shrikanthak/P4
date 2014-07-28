<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('employees',function($table) 
		{
        	$table->boolean('remember_token');
        	$table->boolean('head_of_department')->default(false);
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
		Schema::table('employees', function($table) 
		{
    		$table->dropColumn('remember_token');
    		$table->dropColumn('head_of_department');
    	});

	}

}
