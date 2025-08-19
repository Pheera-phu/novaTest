<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        task::create([
            'issue' => 'พัฒนาระบบ MOC Foudue',
            'task' => 'พัฒนา API สำหรับยุดไฟ Line',
            'project' => 'MOC กระทรวงพาณิชย์',
            'types' => 'งานพัฒนาระบบ',
            'status' => 'เสร็จสิ้น',
            'start_date' => '2025-08-27',
            'end_date' => '2025-08-28',
            'remark' => 'ไม่มีการมอบสมบัติ (อนุมัติโดย GM วันที่ 28/08/2568, 8.00)',
            'author' => 'นาย นมดา กรุณา',
            'testRound' => '0',
            'tester' => 'นาย มุกดา อุบมพา',
        ]);

        task::create([
            'issue' => 'ปรับปรุงระบบการจัดการงาน',
            'task' => 'เพิ่มฟีเจอร์ tracking งาน',
            'project' => 'Internal System',
            'types' => 'งานพัฒนาระบบ',
            'status' => 'กำลังดำเนินการ',
            'start_date' => '2025-08-15',
            'end_date' => '2025-08-30',
            'remark' => 'งานยังไม่เสร็จ กำลังทำอยู่',
            'author' => 'นาย สมชาย ใจดี',
            'testRound' => '1',
            'tester' => 'นาง สุดา เก่งมาก',
        ]);

        task::create([
            'issue' => 'แก้ไข Bug ในระบบ Login',
            'task' => 'แก้ไขปัญหา session timeout',
            'project' => 'Web Application',
            'types' => 'งานแก้ไข Bug',
            'status' => 'รอดำเนินการ',
            'start_date' => '2025-08-20',
            'end_date' => '2025-08-25',
            'remark' => 'รอการอนุมัติจากทีมงาน',
            'author' => 'นาง วิไล ขยันมาก',
            'testRound' => '0',
            'tester' => null,
        ]);

        task::create([
            'issue' => 'อัพเดทระบบความปลอดภัย',
            'task' => 'เพิ่ม 2FA authentication',
            'project' => 'Security Enhancement',
            'types' => 'งานพัฒนาระบบ',
            'status' => 'เสร็จสิ้น',
            'start_date' => '2025-08-10',
            'end_date' => '2025-08-20',
            'remark' => 'งานเสร็จเรียบร้อยแล้ว',
            'author' => 'นาย ปราชญ์ เก่งโค้ด',
            'testRound' => '2',
            'tester' => 'นาย มุกดา อุบมพา',
        ]);
    }
}