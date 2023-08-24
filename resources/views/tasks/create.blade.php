@extends('layouts.app')

@section('content')
    <h1>Add New Task</h1>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="/tasks" method="POST">
        @csrf
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
        <button>Add Task</button>
    </form>
    <a href="/">Back to Task List</a>
@endsection
