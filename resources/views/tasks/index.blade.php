@extends('layouts.app')

@section('content')
    <h1>Task List</h1>
    @foreach ($tasks as $index => $task)
    <div>
        <input type="checkbox" {{ $task['completed'] ? 'checked' : '' }} onchange="event.preventDefault(); document.getElementById('complete-task-{{ $index }}').submit();">
        {{ $task['title'] }}
        <form id="complete-task-{{ $index }}" action="/tasks/{{ $index }}/complete" method="POST" style="display: none;">
            @method('PATCH')
            @csrf
        </form>
        <form action="/tasks/{{ $index }}" method="POST" style="display: inline;">
            @method('DELETE')
            @csrf
            <button>Delete</button>
        </form>
    </div>
@endforeach

    <a href="/tasks/create">Add New Task</a>
@endsection
