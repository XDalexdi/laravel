@extends('layout')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="card-title mb-4">Add New Task</h4>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Deadline</label>
                <input type="date" name="deadline" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection