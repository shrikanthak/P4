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
Route::get('employee/orgchart/{empid}','EmployeeViewController@viewOrgChart');
Route::get('/search/{input}', 'EmployeeViewController@search');
Route::get('/employeebasicview/{login?}',['as'=>'basicviewroute','uses'=>'EmployeeViewController@showEmployeeBasicView']);
Route::post('/employeeportal/save', 'EmployeeViewController@saveEmployeePortal');

//All Authentication Controllers
Route::get('/','AuthenticationController@showWelcome');	
Route::post('/authenticate', ['before'=>'csrf', 'uses'=>'AuthenticationController@authenticate']);
Route::get('/login','AuthenticationController@showLogin');
Route::get('/logout','AuthenticationController@logOut');


//HR Controllers
Route::get('hrpage','HRController@getHRPage');
Route::get('openpositions/{depid}/{empid?}','HRController@getOpenPositions');
Route::post('hr/employee/save/{empid}', ['before'=>'csrf|hrfilter', 'uses'=>'HRController@saveEmployee']);


//seeding the database
Route::get('/dbseeder','DebugController@dbseeder');
//Debug function to view database connection info
Route::get('/testdatabase','DebugController@testdatabase');
Route::get('/test','DebugController@test');

