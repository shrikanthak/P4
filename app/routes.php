<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//-------------------------------------------
//All _master page routes
use Paste\Pre;


//employee routes
//Route for employee to view his data
Route::get('employee/view/{empid}','EmployeeViewController@viewEmployee');
Route::get('employee/orgchart/{id}', array('as'=>'emp_org_chart', 'uses'=>'EmployeeViewController@viewOrgChart'));
Route::get('/search', 'EmployeeViewController@search');
Route::get('/employeebasicview','EmployeeViewController@showEmployeeBasicView');
Route::post('employee/save', ['before'=>'csrf', 'uses'=>'EmployeeViewController@saveEmployeePortal']);

//All Authentication Controllers
Route::get('/','AuthenticationController@showWelcome');	
Route::post('/authenticate', ['before'=>'csrf', 'uses'=>'AuthenticationController@authenticate']);
Route::get('/login','AuthenticationController@showLogin');
Route::get('/logout','AuthenticationController@logOut');


//
Route::get('/hr_access',['before'=>'HRAuthentication','uses'=>'HRController@hrAccess']);
Route::get('/positions/employees','HRController@getPositionsEmployees');


//seeding the database
Route::get('/dbseeder','DebugController@dbseeder');
//Debug function to view database connection info
Route::get('/testdatabase','DebugController@testdatabase');
Route::get('/test','DebugController@test');