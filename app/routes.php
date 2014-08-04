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


//employee routes
//Route for employee to view his data
Route::get('employee/view/{empid}','EmployeePortalController@viewEmployee');
Route::get('employee/orgchart/{empid}/{linktosupervisor?}','EmployeePortalController@viewOrgChart');
Route::get('/search/{input}', 'EmployeePortalController@search');
Route::get('/employeebasicview/{loginid}',['as'=>'basicviewroute','uses'=>'EmployeePortalController@showEmployeeBasicView']);
Route::post('/employeeportal/save', 'EmployeePortalController@saveEmployeePortal');
Route::get('/department/{depid}', 'EmployeePortalController@viewDepartment');

//All Authentication Controllers
Route::post('/authenticate', ['before'=>'csrf', 'uses'=>'AuthenticationController@authenticate']);
Route::get('/login','AuthenticationController@showLogin');
Route::get('/logout','AuthenticationController@logOut');


//Nagivation Controllers
Route::get('/','NavigationController@showWelcome');
Route::get('hrpage',['before'=>'hrfilter','uses'=>'NavigationController@getHRPage']);

//Employee Controllers
Route::post('hr/employee/save/{empid}', ['before'=>'csrf|hrfilter', 'uses'=>'EmployeeController@saveEmployee']);
Route::post('hr/employee/delete', ['before'=>'csrf|hrfilter', 'uses'=>'EmployeeController@deleteEmployee']);
Route::get('hr/openemployeelist', 'EmployeeController@getOpenEmployeeList');

//Positions controllers
Route::get('hr/positionstable/{depid}/{positionstatus}','PositionsController@getPositionsTable');
Route::get('hr/supervisorlist/{depid}/{currentpos}','PositionsController@getSupervisorPositionsList');
Route::post('hr/position/save','PositionsController@savePosition');


//Departments Controllers
Route::post('hr/department/save/','DepartmentController@saveDepartment');

//seeding the database
Route::get('/dbseeder','DebugController@dbseeder');
//Debug function to view database connection info
Route::get('/testdatabase','DebugController@testdatabase');
Route::get('/test','DebugController@test');

