<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskPromotion;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('is_active', 1)->orderBy('id', 'desc')->get();
        return view('backend.tasks.list', compact('tasks'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('backend.tasks.view', compact('task'));
    }
    
    public function promotions()
    {
        $promotions = TaskPromotion::orderBy('created_at','desc')->get();
        return view('backend.tasks.promotions', compact('promotions'));
    }

    /**
     * Approve a task (set is_active = true)
     */
    public function approve(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->approved_at = now();
        $task->approved_by = auth()->id();
        $task->save();
        return back()->with('success', 'Task approved successfully.');
    }

    /**
     * Disapprove a task (set is_active = false)
     */
    public function disapprove(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->approved_at = null;
        $task->approved_by = auth()->id();
        $task->save();
        return back()->with('success', 'Task disapproved successfully.');
    }

    /**
     * Delete a task
     */
    public function delete(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
        ]);
        $task = Task::findOrFail($request->task_id);
        $task->delete();
        return back()->with('success', 'Task deleted successfully.');
    }
}
