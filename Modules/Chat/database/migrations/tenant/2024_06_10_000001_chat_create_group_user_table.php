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
        Schema::create('chat__group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->nullable()->cascadeOnDelete();
            $table->unsignedBigInteger('group_id')->foreign('group_id')->references('id')->on('chat__groups')->onDelete('cascade');
            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat__group_user');
    }
};
