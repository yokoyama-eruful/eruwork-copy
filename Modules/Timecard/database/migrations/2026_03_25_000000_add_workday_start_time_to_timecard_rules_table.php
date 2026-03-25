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
            $table->time('workday_start_time')->default('00:00:00')->after('rule');
        });

        DB::table('timecard__rules')
            ->whereNull('workday_start_time')
            ->update(['workday_start_time' => '00:00:00']);
    }

    public function down(): void
    {
        Schema::table('timecard__rules', function (Blueprint $table) {
            $table->dropColumn('workday_start_time');
        });
    }
};
