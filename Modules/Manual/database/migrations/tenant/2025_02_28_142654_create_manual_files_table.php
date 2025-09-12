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
        Schema::create('manual__files', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumbnail_path');
            $table->string('movie_path')->nullable();
            $table->string('type');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('manual__folder_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('details')->nullable();
            $table->json('steps')->nullable();
            $table->datetimes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual__files');
    }
};
