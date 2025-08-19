@extends('sidebar')

@section('content')
<div class="page-header pt-3">
    <div class="position-relative mb-3">
        <h3 class="text-center">ลางาน</h3>
        <a class="btn btn-primary position-absolute" href="{{ route('history') }}" style="right: 50px; top: 0; ">ประวัติการลา</a>
    </div>
    <div class="d-flex justify-content-center">
        <h5 class="fw-bold">ปี {{ date('Y') }}</h5>
    </div>
    <div class="container mt-2">
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

<div class="form pt-5 pb-5">
    <div class="container">
        <div class="row justify-content-center rounded-3">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <h5 class="text-center fw-bold mb-4">กรอกข้อมูลขอลางาน</h5>
                <form action="{{ route('leave.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="leaveType" class="form-label">ประเภท<span style="color: red;">*</span></label>
                            <select class="form-select" id="types" name="types" required>
                                <option selected disabled>กรุณาเลือก</option>
                                <option value="ลาป่วย">ลาป่วย</option>
                                <option value="ลากิจ">ลากิจ</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">ช่วงเวลา<span style="color: red;">*</span></label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="interval" id="allDay" value="ทั้งวัน" checked>
                                <label class="btn btn-toggle w-50" for="allDay">ทั้งวัน</label>
                                <input type="radio" class="btn-check" name="interval" id="hourly" value="ชั่วโมง">
                                <label class="btn btn-toggle w-50" for="hourly">ชั่วโมง</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="date-range-inputs">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="leaveDate" class="form-label">วันที่ต้องการลา<span style="color: red;">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label">ถึงวันที่<span style="color: red;">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                    <div class="row mb-3 hidden" id="time-inputs">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="startTime" class="form-label">ตั้งแต่เวลา<span style="color: red;">*</span></label>
                            <input type="time" class="form-control" id="start_time" name="start_time">
                        </div>
                        <div class="col-md-6">
                            <label for="endTime" class="form-label">ถึงเวลา<span style="color: red;">*</span></label>
                            <input type="time" class="form-control" id="end_time" name="end_time">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="details" class="form-label">ข้อมูลเพิ่มเติม<span style="color: red;">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="ระบุรายละเอียดเพิ่มเติม" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">ไฟล์แนบ</label>
                        <div class="upload-box">
                            <input class="form-control" type="file" id="additionalFile" name="additionalFile">
                            <div class="mt-2 text-center text-muted">เลือกไฟล์หรือลากวางไฟล์ที่นี่</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit w-100 mb-5">
                        ↖️ ส่งเรื่องขออนุมัติ
                    </button>
                </form>
            </div>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger position-fixed bottom-0 end-0 m-3">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success position-fixed bottom-0 end-0 m-3">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger position-fixed bottom-0 end-0 m-3">
            {{ session('error') }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const intervalRadios = document.querySelectorAll('input[name="interval"]');
        const dateRangeInputs = document.getElementById('date-range-inputs');
        const timeInputs = document.getElementById('time-inputs');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');

        function toggleInputs() {
            if (document.getElementById('hourly').checked) {
                dateRangeInputs.classList.add('hidden');
                timeInputs.classList.remove('hidden');
                const today = new Date().toISOString().slice(0, 10);
                startDateInput.value = today;
                endDateInput.value = today;
                startTimeInput.required = true;
                endTimeInput.required = true;
                startDateInput.required = false;
                endDateInput.required = false;
            } else {
                dateRangeInputs.classList.remove('hidden');
                timeInputs.classList.add('hidden');
                startTimeInput.value = "00:00:00";
                endTimeInput.value = "00:00:00";
                startTimeInput.required = false;
                endTimeInput.required = false;
                startDateInput.required = true;
                endDateInput.required = true;
            }
        }

        intervalRadios.forEach(radio => {
            radio.addEventListener('change', toggleInputs);
        });

        // Initial check
        toggleInputs();

        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                new bootstrap.Alert(alert).close();
            });
        }, 5000);
    });
</script>
@endsection