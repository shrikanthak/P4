<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::table('departments',function($table) 
		{
        	$table->integer('department_head_position_id')->unsigned()->nullable();
        	$table->foreign('department_head_position_id','department_head_position_id_foreign')->references('id')->on('positions');
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
		Schema::table('departments', function($table) 
		{
    		$table->dropForeign('department_head_position_id_foreign');
    		$table->dropColumn('department_head_position_id');
    	});
	}

}
