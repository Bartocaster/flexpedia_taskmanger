<?php
// Here is the task controller where sort, created, update and delted tasks.
namespace App\Http\Controllers;

use Illuminate\Http\Request;
// created the class.
class TaskController extends Controller
{
    public function index()
// {
//      basic no database task storage.
//     $tasks = session('tasks', []);

//     return view('tasks.index', compact('tasks'));
// }
{
    $tasks = session('tasks', []);

    // Sort tasks so that completed tasks are at the bottom
    usort($tasks, function ($a, $b) {
        return $a['completed'] <=> $b['completed'];
    });

    return view('tasks.index', compact('tasks'));
}


public function create()
{
    return view('tasks.create');
}

public function store(Request $request)
{   
    // that was usefull to find valadate whitin composer
    $request->validate([
        'title' => 'required|max:50',
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
        array_splice($tasks, $index, 1);
        session(['tasks' => $tasks]);
    }

    return redirect('/');
}


}
