<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::delete('client/{id}', 'ClientController@destroy');
Route::put('client/{id}', 'ClientController@update');

	Route::get('project/{projectId}/note', 'ProjectNoteController@index');
	Route::post('project/{projectId}/note', 'ProjectNoteController@store');
	Route::get('project/{projectId}/note/{id}', 'ProjectNoteController@show');
	Route::delete('project/{projectId}/note/{id}', 'ProjectNoteController@destroy');
	Route::put('project/{projectId}/note/{id}', 'ProjectNoteController@update');

	Route::get('project/{projectId}/task', 'ProjectTaskController@index');
	Route::post('project/{projectId}/task', 'ProjectTaskController@store');
	Route::get('project/{projectId}/task/{id}', 'ProjectTaskController@show');
	Route::delete('project/{projectId}/task/{id}', 'ProjectTaskController@destroy');
	Route::put('project/{projectId}/task/{id}', 'ProjectTaskController@update');

	Route::get('project/{id}/members', 'ProjectController@members');
	Route::post('project/{id}/member', 'ProjectController@addMember');
	Route::delete('project/{id}/member/{userId}', 'ProjectController@removeMember');
	Route::get('project/{id}/member/{userId}', 'ProjectController@isMember');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::delete('project/{id}', 'ProjectController@destroy');
Route::put('project/{id}', 'ProjectController@update');