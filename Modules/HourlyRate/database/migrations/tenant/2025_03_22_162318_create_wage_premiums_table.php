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
        Schema::create('wage_premiums', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('割増の名称（残業、深夜、休日など）');
            $table->decimal('rate', 5, 2)->comment('割増率（例: 25.00 = 25%）');
            $table->time('start_time')->nullable()->comment('適用開始時間（深夜割増など）');
            $table->time('end_time')->nullable()->comment('適用終了時間');
            $table->tinyInteger('day_of_week')->nullable()->comment('曜日条件（1=月曜, 7=日曜など）');
            $table->boolean('is_holiday')->default(false)->comment('法定休日フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wage_premiums');
    }
};
