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
        Schema::create('calendar__schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->comment('予定のタイトル');
            $table->text('description')->nullable()->comment('予定の説明');
            $table->date('start_date')->comment('予定の開始日');
            $table->date('end_date')->comment('予定の終了日');
            $table->time('start_time')->comment('予定の時間');
            $table->time('end_time')->comment('予定の終了時間');
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar__schedules');
    }
};
