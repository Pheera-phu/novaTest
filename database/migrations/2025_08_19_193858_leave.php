<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->enum('types', ['ลากิจ', 'ลาป่วย']);
            $table->enum('interval', ['ทั้งวัน', 'ชั่วโมง']);
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('description');
            $table->enum('status', ['รอพิจารณา', 'อนุมัติ', 'ไม่อนุมัติ'])->default('รอพิจารณา');
            $table->string('additionalFile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};