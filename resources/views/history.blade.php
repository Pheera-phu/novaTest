@extends('sidebar')

@section('content')
<div class="page-header pt-3">
    <div class="position-relative mb-3">
        <h3 class="text-center">ประวัติการลา</h3>
        <a class="btn btn-primary position-absolute" href="{{ route('leave') }}" style="right: 50px; top: 0; ">กลับ</a>
    </div>
    <div class="d-flex justify-content-center">
        <h5 class="fw-bold">ปี {{ date('Y') }}</h5>
    </div>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                    <div class="text-center flex-grow-1">
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <div class="fw-bold fs-5">คุณได้ลางานไปแล้วทั้งหมด</div>
                            <div class="bg-primary text-white rounded-3 py-2 px-4">
                                {{ $leaveStats['total'] }} วัน
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-4 flex-wrap">
                    <div class="text-center">
                        <div class="mb-2">• ลากิจ</div>
                        <div class="rounded-3 py-2 px-4 text-white" style="background-color: #6f42c1;">
                            {{ $leaveStats['business'] }} วัน
                        </div>
                    </div>
                    <div class="border-end d-none d-md-block"></div>
                    <div class="text-center">
                        <div class="mb-2">• ลาป่วย</div>
                        <div class="rounded-3 py-2 px-4 text-white" style="background-color: #5bc0de;">
                            {{ $leaveStats['sick'] }} วัน
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-sm-12">
                <h5 class="text-center fw-bold mb-4">ประวัติการลา</h5>

                @forelse($leaves as $leave)
                <div class="card-leave mb-3 border border-tertiary shadow rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                        <div>
                            @if($leave->types == 'ลาป่วย')
                            <i class="bi bi-thermometer-half leave-icon text-danger"></i>
                            @else
                            <i class="bi bi-suitcase-lg leave-icon text-primary"></i>
                            @endif
                            <span class="leave-title">{{ $leave->types }}</span>
                        </div>

                        @if($leave->status == 'รอพิจารณา')
                        <span class="status status-waiting"> {{ $leave->status }} </span>
                        @elseif($leave->status == 'อนุมัติ')
                        <span class="status status-approved"> {{ $leave->status }} </span>
                        @else
                        <span class="status status-deny"> {{ $leave->status }} </span>
                        @endif
                    </div>

                    <div class="text-detail mb-2">
                        <i class="bi bi-calendar3"></i>
                        @if($leave->interval == 'ชั่วโมง')
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} ({{ $leave->interval }})
                        <br><i class="bi bi-clock"></i> {{ $leave->start_time }} น. - {{ $leave->end_time }} น.
                        @else
                        {{ \Carbon\Carbon::parse($leave->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d/m/Y') }} ({{ $leave->interval }})
                        @endif
                    </div>

                    <div class="text-detail">
                        <i class="bi bi-chat-left-text"></i>
                        {{ $leave->description }}
                    </div>
                </div>
                @empty
                <div class="text-center text-muted mt-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    <h4>ไม่พบประวัติการลา</h4>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection