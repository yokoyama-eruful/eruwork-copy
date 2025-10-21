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
        Schema::create('chat__groups', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_dm')->default(false);
            $table->string('name')->nullable();
            $table->text('icon')->nullable();
            $table->datetimes();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat__groups');
    }
};
