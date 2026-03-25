<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('timecard__wage_premiums', function (Blueprint $table) {
            $table->string('overtime_over_60_rate')->default(50)->after('overtime_rate');
            $table->string('holiday_rate')->default(35)->after('night_rate');
        });
    }

    public function down(): void
    {
        Schema::table('timecard__wage_premiums', function (Blueprint $table) {
            $table->dropColumn(['overtime_over_60_rate', 'holiday_rate']);
        });
    }
};
