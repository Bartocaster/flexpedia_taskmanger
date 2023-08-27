<?php
// Here is the task controller where sort, created, update and delted tasks.
namespace App\Http\Controllers;
use Illuminate\Http\Request;

// created the class.
class TaskController extends Controller
{
    /**
     * Display a list of tasks, sorted by completion status.
     *
     * @return \Illuminate\View\View The view displaying the list of tasks.
     */
    public function index()
{
    // Retrieve the tasks array from the session
    $tasks = session('tasks', []);

    // Sort tasks so that completed tasks are at the bottom
    usort($tasks, function ($a, $b) {
        return $a['completed'] <=> $b['completed'];
    });
    // Return the view with the sorted tasks    
    return view('tasks.index', compact('tasks'));
}
    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\View\View The view for creating a new task.
     */
public function create()
{
    return view('tasks.create');
}
    /**
     * Store a newly created task in the session.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing task data.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the main page after storing the task.
     */
public function store(Request $request)
{
    // Validate the input
    $request->validate([
        'title' => 'required|max:50',
    ]);
    // Generate a unique identifier for the task
    $lookUp= uniqid(); 

    // Retrieve and update the tasks array in the session
    $task = [
        'title' => $request->title,
        'uuid' => $lookUp,
        'completed' => false,
    ];

    // Retrieve the existing tasks from the session
    $tasks = session('tasks', []);

    // Add the new task to the tasks array
    $tasks[] = $task;

    // Store the updated tasks array in the session
    session(['tasks' => $tasks]);

    // Redirect back to the main page after storing the task
    return redirect('/');
}
 /**
     * Mark a task as completed or incomplete and adjust its position in the list.
     *
     * @param string $uuid The UUID of the task to mark as completed or incomplete.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the main page after updating the task.
     */

public function complete($uuid)
{
    $tasks = session('tasks', []);

    foreach ($tasks as $index => &$task) {
        if ($task['uuid'] === $uuid) {
            $task['completed'] = !$task['completed'];
            if ($task['completed']) {
                // Remove the task from its current position and push it to the end
                unset($tasks[$index]);
                $tasks[] = $task;
            } else {
                // Remove the task from its current position and unshift it to the beginning
                unset($tasks[$index]);
                array_unshift($tasks, $task);
            }
            break;
        }
    }

    session(['tasks' => $tasks]);

    return redirect('/');
}
    /**
     * Delete a task from the session.
     *
     * @param string $uuid The UUID of the task to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the main page after deleting the task.
     */
public function destroy($uuid)
{
    $tasks = session('tasks', []);

    foreach ($tasks as $index => $task) {
        if ($task['uuid'] === $uuid) {
            unset($tasks[$index]);
            break;
        }
    }

    session(['tasks' => $tasks]);

    return redirect('/');
}

}
