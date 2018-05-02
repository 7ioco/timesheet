<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');
Route::get('user-types-list', 'API\PassportController@userTypesList');

Route::group(['middleware' => 'auth:api'], function(){
    /** Passport Controller ****/
	Route::post('get-details', 'API\PassportController@getDetails');
    Route::get('users-list', 'API\PassportController@userList');
    Route::post('user-update/{id}', 'API\PassportController@userUpdate');
    Route::get('user-details/{id}', 'API\PassportController@userDetails');
    Route::get('user-delete/{id}', 'API\PassportController@userDelete');
    /** Passport Controller End ****/
    
    /** Projects Controller ****/
    Route::post('project-add', 'API\ProjectsController@projectAdd');
    Route::get('projects-list', 'API\ProjectsController@projectsList');
    Route::get('project-details/{id}', 'API\ProjectsController@projectDetails');
    Route::post('project-update/{id}', 'API\ProjectsController@projectUpdate');
    Route::get('project-delete/{id}', 'API\ProjectsController@projectDelete');
    
    Route::post('timesheet-add', 'API\ProjectsController@timesheetAdd');
    Route::post('timesheet-update/{id}', 'API\ProjectsController@timesheetUpdate');
    Route::get('timesheet-details/{id}', 'API\ProjectsController@timesheetDetails');
    Route::post('timesheet-list', 'API\ProjectsController@timesheetList');
    Route::get('timesheet-details-list/{id}', 'API\ProjectsController@timesheetDetailsList');
    Route::post('timesheet-list-by-position', 'API\ProjectsController@timesheetListByPosition');
    /** Projects Controller End ****/
});