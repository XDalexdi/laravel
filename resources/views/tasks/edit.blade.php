@extends('layout')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Edit Task</h4>
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $task->description }}</textarea>
            </div>
            <div class="mb-3">
                <label>Deadline</label>
                <input type="date" name="deadline" class="form-control" value="{{ $task->deadline }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection