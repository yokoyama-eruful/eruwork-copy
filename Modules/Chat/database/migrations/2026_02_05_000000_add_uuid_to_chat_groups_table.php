<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat__groups', function (Blueprint $table) {
            $table->uuid('uuid')
                ->nullable()
                ->after('id');
        });

        // 既存データにuuidを入れる
        DB::table('chat__groups')
            ->whereNull('uuid')
            ->get()
            ->each(function ($group) {
                DB::table('chat__groups')
                    ->where('id', $group->id)
                    ->update(['uuid' => (string) Str::uuid()]);
            });

        Schema::table('chat__groups', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('chat__groups', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
