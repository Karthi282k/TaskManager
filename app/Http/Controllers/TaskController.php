<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('order')->get();
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
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => Task::max('order') + 1
        ]);

        return redirect('/')->with('success', 'Task added successfully.');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect('/')->with('success', 'Task updated successfully.');
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return redirect('/')->with('success', 'Task deleted successfully.');
    }

    public function toggle($id)
    {
        $task = Task::findOrFail($id);
        $task->update(['is_completed' => !$task->is_completed]);
        return redirect('/')->with('success', 'Task status updated.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Task::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
