<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// created the class.
class TaskController extends Controller
{
    public function index()
{
    $tasks = session('tasks', []);

    return view('tasks.index', compact('tasks'));
}

public function create()
{
    return view('tasks.create');
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
    ]);

    $task = ['title' => $request->title, 'completed' => false];

    session()->push('tasks', $task);

    return redirect('/');
}
public function complete($index)
{
    $tasks = session('tasks', []);

    if (isset($tasks[$index])) {
        $tasks[$index]['completed'] = !$tasks[$index]['completed'];
        session(['tasks' => $tasks]);
    }

    return redirect('/');
}

// delete works properly now 
public function destroy($index)
{
    $tasks = session('tasks', []);

    if (isset($tasks[$index])) {
        unset($tasks[$index]);
        session()->put('tasks', $tasks);
    }

    return redirect('/');
}

}
