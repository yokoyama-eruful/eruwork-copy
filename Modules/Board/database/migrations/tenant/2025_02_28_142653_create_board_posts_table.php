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
        Schema::create('board__posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('contents');
            $table->string('status');
            $table->foreignId('user_id')->constrained()->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board__posts');
    }
};
