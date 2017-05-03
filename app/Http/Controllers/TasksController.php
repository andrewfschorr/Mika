<?php

namespace App\Http\Controllers;

use App\Task;

class TasksController extends Controller
{
    //
    public function index()
    {
        $tasks = Task::all();
        return view('foo', compact('tasks'));
    }

    public function show($id)
    {
        $task = Task::find($id);
        return view('task', compact('task'));
    }
}
