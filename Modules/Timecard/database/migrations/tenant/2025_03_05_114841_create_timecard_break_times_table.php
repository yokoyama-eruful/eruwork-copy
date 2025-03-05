<?php

declare(strict_types=1);

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
        Schema::create('timecard__break_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('timecard__attendances')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timecard__break_times');
    }
};
