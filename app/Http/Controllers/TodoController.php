<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // Display all tasks
    public function index()
    {
        $todos = Todo::latest()->get();

        return view('todos.index', compact('todos'));
    }

    // Add a new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Todo::create($validated);

        return redirect()->route('todos.index')
            ->with('success', 'Task added successfully!');
    }

    // Edit a task or update its completion status
    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $todo->update([
            'title' => $validated['title'],
            'is_completed' => $request->boolean('is_completed'),
        ]);

        return redirect()->route('todos.index')
            ->with('success', 'Task updated successfully!');
    }

    // Delete a task
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Task deleted successfully!');
    }
}