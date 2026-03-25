<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timecard__rules', function (Blueprint $table) {
            $table->unsignedTinyInteger('statutory_holiday_weekday')->default(0)->after('workday_start_time');
        });
    }

    public function down(): void
    {
        Schema::table('timecard__rules', function (Blueprint $table) {
            $table->dropColumn('statutory_holiday_weekday');
        });
    }
};
