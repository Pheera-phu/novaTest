<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Nova\CustomMenuController;

Route::get('/', [LeaveController::class, 'index'])->name('index');
Route::get('/navbar', [LeaveController::class, 'navbar'])->name('navber');
Route::get('/leave', [LeaveController::class, 'leave'])->name('leave');
Route::get('/history', [LeaveController::class, 'history'])->name('history');
Route::get('/task', [TaskController::class, 'index'])->name('task');
Route::post('/leave/store', [LeaveController::class, 'store'])->name('leave.store');
Route::get('/leave/approve', [LeaveController::class, 'approve'])->name('leave.approve');
Route::get('/leave/reject', [LeaveController::class, 'reject'])->name('leave.reject');

