<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        
        if ($request->has('status') && in_array($request->status, ['pending', 'done'])) {
            $query->where('status', $request->status);
        }

       
        $tasks = $query->latest()->paginate(5)->withQueryString();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);

        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }

  
    public function toggleComplete(Task $task, Request $request)
    {
        $task->status = $task->status === 'pending' ? 'done' : 'pending';
        $task->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'new_status' => $task->status]);
        }

        return back()->with('success', 'Task status updated!');
    }
}