@extends('sidebar')

@section('content')
<div class="container-fluid p-0">
    <div class="task-header">
        <!-- Header -->
        <h4 class="mb-4"><strong>รายการงานของฉัน</strong></h4>

        <!-- Summary Section -->
        <div class="row mb-4">
            <!-- Total Tasks Card -->
            <div class="col-12 mb-3">
                <div class="card" style="background: linear-gradient(135deg, #6cc5c5, #4a9a9a); border: none; border-radius: 15px;">
                    <div class="card-body text-center text-white py-4">
                        <h5 class="card-title mb-2">งานที่ได้รับมอบหมายทั้งหมด</h5>
                        <h1 class="display-4 mb-0" style="font-weight: bold;">{{ $taskStats['total'] ?? 0 }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-white" style="background-color: #e74c3c; border: none; border-radius: 15px;">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-hourglass-split" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <h6 class="card-title mb-2">รอดำเนินการ</h6>
                        <h2 class="mb-0" style="font-weight: bold;">{{ $taskStats['pending'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white" style="background-color: #f39c12; border: none; border-radius: 15px;">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-clock-history" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <h6 class="card-title mb-2">กำลังดำเนินการ</h6>
                        <h2 class="mb-0" style="font-weight: bold;">{{ $taskStats['in_progress'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card text-white" style="background-color: #27ae60; border: none; border-radius: 15px;">
                    <div class="card-body text-center py-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <h6 class="card-title mb-2">เสร็จสิ้น</h6>
                        <h2 class="mb-0" style="font-weight: bold;">{{ $taskStats['completed'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="row mb-4">
        <div class="col-12 text-center">
            <button class="btn btn-primary me-2 mb-2" style="border-radius: 20px;">
                <i class="bi bi-list-ul"></i> มุมมองรายการ
            </button>
            <button class="btn btn-outline-secondary mb-2" style="border-radius: 20px;">
                <i class="bi bi-calendar"></i> มุมมองปฏิทิน
            </button>
        </div>
    </div>

    <!-- Task Cards -->
    <div class="task-card row">
        @forelse($tasks ?? [] as $task)
        <div class="col-12 mb-3">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                @php
                if($task->status == 'กำลังดำเนินการ') {
                $headerColor = '#f39c12';
                $statusIcon = 'bi-clock';
                $statusText = 'กำลังดำเนินการ';
                $btnClass = 'btn-warning';
                } elseif($task->status == 'เสร็จสิ้น') {
                $headerColor = '#27ae60';
                $statusIcon = 'bi-check-circle';
                $statusText = 'เสร็จสิ้น';
                $btnClass = 'btn-success';
                } elseif($task->status == 'รอดำเนินการ') {
                $headerColor = '#6c757d';
                $statusIcon = 'bi-hourglass-split';
                $statusText = 'รอดำเนินการ';
                $btnclass = 'btn-secondary';
                } else {
                $headerColor = '#6c757d';
                $statusIcon = 'bi-question-circle';
                $statusText = $task->status;
                $btnClass = 'btn-secondary';
                }
                @endphp

                <div class="card-header text-white" style="background-color: {{ $headerColor }}; border-radius: 15px 15px 0 0;">
                    <h6 class="mb-0">
                        <strong>Issue:</strong> {{ $task->issue }}<br>
                        <small>• Task: {{ $task->task }}</small>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>โครงการ:</strong> <span class="text-primary">{{ $task->project }}</span></p>
                            <p class="mb-1"><strong>ประเภท:</strong> {{ $task->types }}</p>
                            <p class="mb-1"><strong>ผู้รับผิดชอบ:</strong> {{ $task->author }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn {{ $btnClass }} btn-sm mb-2" style="border-radius: 20px;">
                                <i class="bi {{ $statusIcon }}"></i> {{ $statusText }}
                            </button>
                            @if($task->status == 'กำลังดำเนินการ' || $task->status == 'รอดำเนินการ')
                            <button class="btn btn-outline-primary btn-sm mb-2" style="border-radius: 20px;">
                                <i class="bi bi-play-circle"></i> อัปเดต
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Collapsible Details -->
                    <div class="mt-3">
                        <button class="btn btn-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#taskDetails{{ $task->id }}">
                            รายละเอียดงาน <i class="bi bi-chevron-down"></i>
                        </button>
                        <div class="collapse mt-3" id="taskDetails{{ $task->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>วันที่เริ่มต้น:</strong> {{ \Carbon\Carbon::parse($task->start_date)->format('d/m/Y') }}</p>
                                    <p><strong>วันที่สิ้นสุด:</strong> {{ \Carbon\Carbon::parse($task->end_date)->format('d/m/Y') }}</p>
                                    @if($task->remark)
                                    <p><strong>หมายเหตุ:</strong> {{ $task->remark }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>การตรวจสอบคุณภาพ</strong></h6>
                                    <p><strong>รอบการทดสอบ:</strong> {{ $task->testRound }} ครั้ง</p>
                                    @if($task->tester)
                                    <p><strong>ผู้ตรวจสอบ:</strong> {{ $task->tester }}</p>
                                    @endif
                                    @if($task->additionalFile)
                                    <p><strong>ไฟล์แนบ:</strong> <a href="{{ asset('storage/' . $task->additionalFile) }}" target="_blank">ดาวน์โหลด</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> ไม่มีงานในระบบ
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endsection