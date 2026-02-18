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
        Schema::table('user_limits', function (Blueprint $table) {
            $table->timestamp('central_updated_at')->nullable()->after('user_limit');
            $table->timestamp('synced_at')->nullable()->after('central_updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_limits', function (Blueprint $table) {
            $table->dropColumn(['central_updated_at', 'synced_at']);
        });
    }
};
