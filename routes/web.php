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
use App\Task;
Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{id}', 'TasksController@show');
Route::get('/', 'PostController@index');
Route::get('/create', 'PostController@create');
Route::post('/posts', 'PostController@store');

Route::get('/foo', function () {
    //$tasks = DB::table('tasks')->get();
    $tasks = App\Task::all();
    return view('foo', compact('tasks'));
});

Route::get('/foo/{id}', function ($id) {
    // $task = DB::table('tasks')->find($id);
    // dd($task);
    $task = App\Task::find($id);
    return view('task', compact('task'));
});

Route::get('/foo/i', function () {
    $tasks = App\Task::incomplete();
    return view('foo', compact('tasks'));
});
Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

// OAuth Routes
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Auth::routes();

Route::get('/home', 'HomeController@index');
