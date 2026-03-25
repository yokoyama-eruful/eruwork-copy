<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timecard__rules', function (Blueprint $table) {
            $table->json('holiday_weekdays')->nullable()->after('statutory_holiday_weekday');
            $table->json('holiday_dates')->nullable()->after('holiday_weekdays');
        });

        DB::table('timecard__rules')
            ->whereNull('holiday_weekdays')
            ->update([
                'holiday_weekdays' => DB::raw("json_build_array(statutory_holiday_weekday)"),
                'holiday_dates' => json_encode([]),
            ]);
    }

    public function down(): void
    {
        Schema::table('timecard__rules', function (Blueprint $table) {
            $table->dropColumn(['holiday_weekdays', 'holiday_dates']);
        });
    }
};
