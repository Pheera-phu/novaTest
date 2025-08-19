<?php

namespace App\Http\Controllers;

use App\Models\leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\leaveNotification;
use App\Mail\statusNotification;

class LeaveController extends Controller
{
    public function __construct()
    {
        $totalLeaves = Leave::count();
        $businessLeaves = Leave::where('types', 'ลากิจ')->count();
        $sickLeaves = Leave::where('types', 'ลาป่วย')->count();

        View::share('leaveStats', [
            'total' => $totalLeaves,
            'business' => $businessLeaves,
            'sick' => $sickLeaves
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function leave()
    {
        return view('leave');
    }

    public function navbar()
    {
        return view('navbar');
    }

    public function history()
    {
        $leaves = Leave::orderBy('created_at', 'desc')->get();
        return view('history', compact('leaves'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'types' => 'required|in:ลากิจ,ลาป่วย',
            'interval' => 'required|in:ทั้งวัน,ชั่วโมง',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'description' => 'required|string',
            'additionalFile' => 'nullable|file|max:2048'
        ]);

        $data = [
            'types' => $request->types,
            'interval' => $request->interval,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
            'status' => 'รอพิจารณา',
        ];

        if ($request->hasFile('additionalFile')) {
            $filename = $request->file('additionalFile')->getClientOriginalName();
            $path = $request->file('additionalFile')->storeAs('additional_files', $filename, 'public');
            $data['additionalFile'] = $path;
        }

        try {
            $leave = Leave::create($data);

            #$noti = Mail::to('test@test.com')->queue(new leaveNotification($leave));

            if ($leave) {
                return redirect()->route('index')->with('success', 'บันทึกสำเร็จ');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดขึ้น: ' . $e->getMessage());
        }
    }

    public function status(Request $uStatus, $id)
    {
        $uStatus->validate(['status' => 'required|in:อนุมัติ,ไม่อนุมัติ']);
        $found = Leave::findOrFail($id);

        if ($found->status !== 'รอพิจารณา') {
            return response()->json(['error' => 'สถานะไม่ใช่ รอพิจารณา'], 403);
        }

        try {
            $found->status = $uStatus->status;
            $success = $found->save();

            #Mail::to('reciever@example.com')->queue(new statusNotification($found));

            return response()->json(['success' => 'Update success']);
        } catch (\Exception $e) {
            return response()->json([$e->getMessage()]);
        }
    }

    public function approve(Request $request)
    {
        $leave = Leave::findOrFail($request->query('id'));
        if ($leave->status == 'รอพิจารณา') {
            $id = $leave->id;
            $leave->status = 'อนุมัติ';
            $leave->save();

            #Mail::to('test@test.com')->queue(new statusNotification($leave));

            return view('emails.status-updated', ['status' => 'อนุมัติ', 'id' => $id]);
        } else {
            return view('emails.status-update-fail');
        }
    }

    public function reject(Request $request)
    {
        $leave = Leave::findOrFail($request->query('id'));
        if ($leave->status == 'รอพิจารณา') {
            $id = $leave->id;
            $leave->status = 'ไม่อนุมัติ';
            $leave->save();

            #Mail::to('test@test.com')->queue(new statusNotification($leave));
        
            return view('emails.status-updated', ['status' => 'ไม่อนุมัติ', 'id' => $id]);
        } else {
            return view('emails.status-update-fail');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(leave $leave)
    {
        //
    }
}