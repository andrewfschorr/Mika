<?php

use App\Task;

Route::get('/',                         'GuestController@index');
Route::get('/home',                     'AuthController@home');
Route::get('/edit/{user}/{album}',      'AuthController@editAlbum');
Route::get('/album/{user}/{album}',     'AlbumController@viewAlbum');
Route::post('/createalbum',             'AuthAjaxController@createAlbum');
Route::post('/updateAlbum',             'AuthAjaxController@updateAlbum');
Route::get('/auth/instagram',           'Auth\LoginController@authInstagram');
Route::get('/auth/instagram/callback',  'Auth\LoginController@authInstagramCallback');
Route::get('/search-term/{term}',       'IgProxyController@index');
Route::get('/about'             ,       'StaticController@about');
Auth::routes();

/**
 * Test routes
 */
Route::get('/tasks', 'TasksController@index');
Route::get('/tasks/{id}', 'TasksController@show');
Route::get('/foo', function () {
    //$tasks = DB::table('tasks')->get();
    $tasks = App\Task::all();
    return view('foo', compact('tasks'));
});
Route::get('/foo/{id}', function ($id) {
    // $task = DB::table('tasks')->find($id);
    $task = App\Task::find($id);
    return view('task', compact('task'));
});

Route::get('/incomplete', function () {
    $tasks = App\Task::incomplete();
    return view('foo', compact('tasks'));
});
