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
