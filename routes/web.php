<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tasklist', 'TasklistController@index')->name('task-list');
Route::get('/tasklist/archived', 'TasklistController@getArchivedTasks')->name('archived-tasks');

Route::get('/tasklist/fetch', 'TasklistController@getTasklist');

Route::post('tasklist/addTask', 'TasklistController@addNewTask');
Route::post('tasklist/shareTask', 'TasklistController@shareTask');
Route::post('tasklist/editTask', 'TasklistController@editTask');
Route::post('tasklist/removeTask', 'TasklistController@removeTask');
Route::post('tasklist/toggleStatus', 'TasklistController@toggleTaskCompletionStatus');

Route::post('tasklist/startTimer', 'TasklistController@startTimer');
Route::post('tasklist/stopTimer', 'TasklistController@stopTimer');

Route::get('task/{id}/timelogs', 'TaskController@viewTimelogs')->name('viewTimelogs');

Route::get('colleagues', 'ColleagueController@index')->name('colleagues');
Route::post('colleagues/search', 'ColleagueController@search');
Route::post('colleagues/requestAdd', 'ColleagueController@requestAdd');
Route::post('colleagues/requestResponse', 'ColleagueController@postRequestResponse');
Route::get('colleagues/getColleagues', 'ColleagueController@getColleagues');
Route::get('colleagues/getColleagueRequests', 'ColleagueController@getColleagueRequests');

Route::get('notifications', 'NotificationController@index')->name('notifications');
