@extends('sidebar')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <h4 class="mb-4"><strong>สำหรับพนักงาน / เจ้าหน้าที่ทั่วไป</strong></h4>

    <!-- General Staff Section - All in one row -->
    <div class="row mb-5">
        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">ลงเวลาทำงาน</p>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <a href="{{ route('task') }}" class="text-decoration-none">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-file-text-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">งานของฉัน</p>
            </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-bar-chart-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">สรุปผลงาน</p>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-trophy-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">รางวัลที่ได้</p>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-display-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">ผลการประเมิน</p>
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <a href="{{ route('leave') }}" class="text-decoration-none">
                <div class="text-center">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                        <i class="bi bi-exclamation-triangle-fill text-white" style="font-size: 2rem;"></i>
                    </div>
                    <p class="text-primary mb-0 small">การลา</p>
                </div>
            </a>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-arrow-repeat text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">สมุดโทรศัพท์</p>
            </div>
        </div>
    </div>

    <!-- Project Team Header -->
    <h4 class="mb-4"><strong>สำหรับ Project Team และ ผู้บริหาร</strong></h4>

    <!-- Project Team Section -->
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-graph-up-arrow text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">ความคืบหน้า<br>โครงการ</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-calendar-event-fill text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">วางแผนงาน</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-4 mb-3">
            <div class="text-center">
                <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px;">
                    <i class="bi bi-speedometer2 text-white" style="font-size: 2rem;"></i>
                </div>
                <p class="text-primary mb-0 small">ตรวจคุณภาพ<br>ตามมาตรฐาน</p>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for smaller screens -->
<style>
    @media (max-width: 768px) {
        .bg-primary.rounded-circle {
            width: 60px !important;
            height: 60px !important;
        }

        .bg-primary.rounded-circle i {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .bg-primary.rounded-circle {
            width: 50px !important;
            height: 50px !important;
        }

        .bg-primary.rounded-circle i {
            font-size: 1.2rem !important;
        }

        .small {
            font-size: 0.75rem !important;
        }
    }
</style>

<!-- Bootstrap Icons CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
@endsection