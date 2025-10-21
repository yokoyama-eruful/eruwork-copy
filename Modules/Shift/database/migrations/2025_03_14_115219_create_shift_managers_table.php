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
        Schema::create('shift__managers', function (Blueprint $table) {
            $table->id();
            $table->date('start_date'); // シフト開始日
            $table->date('end_date');   // シフト終了日
            $table->date('submission_start_date'); // 提出開始日
            $table->date('submission_end_date');   // 提出締切日
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift__managers');
    }
};
