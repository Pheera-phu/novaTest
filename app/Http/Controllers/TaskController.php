<?php

namespace App\Http\Controllers;

use App\Models\task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get task statistics
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'รอดำเนินการ')->count();
        $inProgressTasks = Task::where('status', 'กำลังดำเนินการ')->count();
        $completedTasks = Task::where('status', 'เสร็จสิ้น')->count();

        // Get all tasks ordered by created date
        $tasks = Task::orderBy('created_at', 'desc')->get();

        $taskStats = [
            'total' => $totalTasks,
            'pending' => $pendingTasks,
            'in_progress' => $inProgressTasks,
            'completed' => $completedTasks
        ];

        return view('Task', compact('tasks', 'taskStats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}