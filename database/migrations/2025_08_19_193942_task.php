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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->text('issue');
            $table->text('task');
            $table->text('project');
            $table->text('types');
            $table->enum('status', ['รอดำเนินการ', 'กำลังดำเนินการ', 'เสร็จสิ้น'])->default('รอดำเนินการ');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('remark')->nullable();
            $table->text('author');
            $table->text('testRound')->nullable();
            $table->text('tester')->nullable();
            $table->string('additionalFile')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};