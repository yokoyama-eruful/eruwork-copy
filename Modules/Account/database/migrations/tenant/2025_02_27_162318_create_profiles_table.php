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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('icon')->nullable();
            $table->string('name');
            $table->string('name_kana')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->date('hire_date')->nullable();

            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone_number')->nullable();
            $table->string('emergency_relationship')->nullable();

            $table->dateTime('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
