@extends('layout')

@section('content')
<div class="row mb-3 align-items-center">
    <div class="col-md-3">
        <h2>My Tasks</h2>
    </div>
    
    <div class="col-md-4">
        <form action="{{ route('tasks.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search tasks..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-dark btn-sm">Search</button>
        </form>
    </div>

    <div class="col-md-5 text-end">
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-sm">All</a>
        <a href="{{ route('tasks.index', ['status' => 'pending']) }}" class="btn btn-outline-warning btn-sm">Pending</a>
        <a href="{{ route('tasks.index', ['status' => 'done']) }}" class="btn btn-outline-success btn-sm">Done</a>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm ms-2">+ Add Task</a>
    </div>
</div>

<table class="table table-bordered bg-white shadow-sm">
    <thead class="table-light">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($tasks as $task)
        <tr id="task-row-{{ $task->id }}">
            <td class="task-title" style="{{ $task->status === 'done' ? 'text-decoration: line-through; color: gray;' : '' }}">
                {{ $task->title }}
            </td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->deadline }}</td>
            <td>
                <span class="badge status-badge {{ $task->status === 'done' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($task->status) }}
                </span>
            </td>
            <td>
                <button onclick="toggleTask({{ $task->id }})" class="btn btn-sm btn-info text-white">Toggle</button>
                
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center">No tasks found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $tasks->links() }}
</div>

<script>
    function toggleTask(taskId) {
        fetch(`/tasks/${taskId}/toggle`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                let row = document.getElementById(`task-row-${taskId}`);
                let badge = row.querySelector('.status-badge');
                let title = row.querySelector('.task-title');

                if(data.new_status === 'done') {
                    badge.className = 'badge status-badge bg-success';
                    badge.innerText = 'Done';
                    title.style.textDecoration = 'line-through';
                    title.style.color = 'gray';
                } else {
                    badge.className = 'badge status-badge bg-warning text-dark';
                    badge.innerText = 'Pending';
                    title.style.textDecoration = 'none';
                    title.style.color = 'inherit';
                }
            }
        });
    }
</script>
@endsection