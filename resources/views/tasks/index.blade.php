@extends('layouts.app')

@section('page-title')
    Task List
@endsection

@section('content')
    <h2>Incompleted Tasks</h2>
    @foreach ($tasks as $task)
        @if (!$task['completed'])
            <div>
                <input type="checkbox" {{ $task['completed'] ? 'checked' : '' }} onchange="event.preventDefault(); document.getElementById('complete-task-{{ $task['uuid'] }}').submit();">
                {{ $task['title'] }}
                <form id="complete-task-{{ $task['uuid'] }}" action="/tasks/{{ $task['uuid'] }}/complete" method="POST" style="display: none;">
                    @method('PATCH')
                    @csrf
                </form>
                <form action="/tasks/{{ $task['uuid'] }}" method="POST" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <button>Delete</button>
                </form>
            </div>
        @endif
    @endforeach

    <hr>

    <h2>Completed Tasks</h2>
    @foreach ($tasks as $task)
        @if ($task['completed'])
            <div>
                <input type="checkbox" {{ $task['completed'] ? 'checked' : '' }} onchange="event.preventDefault(); document.getElementById('complete-task-{{ $task['uuid'] }}').submit();">
                {{ $task['title'] }}
                {{ $task['uuid'] }}
                <form id="complete-task-{{ $task['uuid'] }}" action="/tasks/{{ $task['uuid'] }}/complete" method="POST" style="display: none;">
                    @method('PATCH')
                    @csrf
                </form>
                <form action="/tasks/{{ $task['uuid'] }}" method="POST" style="display: inline;">
                    @method('DELETE')
                    @csrf
                    <button>Delete</button>
                </form>
            </div>
        @endif
    @endforeach

    <a href="/tasks/create">Add New Task</a>
@endsection
