<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\task;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/tasks', function (Request $request) {
    $totalTasks = task::count();
    $pendingTasks = task::where('status', 'รอดำเนินการ')->count();
    $inProgressTasks = task::where('status', 'กำลังดำเนินการ')->count();
    $completedTasks = task::where('status', 'เสร็จสิ้น')->count();

    $tasks = task::orderBy('created_at', 'desc')->get();

    return response()->json([
        'stats' => [
            'total' => $totalTasks,
            'pending' => $pendingTasks,
            'in_progress' => $inProgressTasks,
            'completed' => $completedTasks
        ],
        'tasks' => $tasks
    ]);
});
