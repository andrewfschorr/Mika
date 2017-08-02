<?php

namespace App\Http\Controllers;

use App\Task;

class TasksController extends Controller
{
    //
    public function index()
    {
        $tasks = Task::all();
        \Log::info($tasks);
        return view('foo', compact('tasks'));
    }

    public function show($id)
    {
        $task = Task::find($id);
        return view('task', compact('task'));
    }
}
