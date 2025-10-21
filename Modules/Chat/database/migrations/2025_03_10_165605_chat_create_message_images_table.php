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
        Schema::create('chat__message_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id')->foreign('message_id')->references('id')->on('chat__messages')->onDelete('cascade');
            $table->string('file_path');
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat__message_images');
    }
};
