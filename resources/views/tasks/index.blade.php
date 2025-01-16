@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Tasks</h1>
    </br>
    <form method="GET" action="{{ route('tasks.index') }}" class="mb-3">
        <select name="status" class="form-control" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </form>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>
    </br>
</br>
    <div class="mb-3">
        <a href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'asc'])) }}" class="btn btn-info btn-sm">Sort by Due Date (Asc)</a>
        <a href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'desc'])) }}" class="btn btn-info btn-sm">Sort by Due Date (Desc)</a>
    </div>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->status }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
