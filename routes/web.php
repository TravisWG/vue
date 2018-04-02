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

Route::get('/tasklist/fetch/incomplete', 'TasklistController@getTasklist');
Route::get('/tasklist/fetch/completed', 'TasklistController@getCompletedTasklist');

Route::post('tasklist/addTask', 'TasklistController@addNewTask');
Route::post('tasklist/editTask', 'TasklistController@editTask');
Route::post('tasklist/removeTask', 'TasklistController@removeTask');
Route::post('tasklist/toggleStatus', 'TasklistController@toggleTaskCompletionStatus');