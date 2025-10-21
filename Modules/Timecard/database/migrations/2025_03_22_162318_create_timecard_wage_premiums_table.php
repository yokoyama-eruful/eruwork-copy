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
        Schema::create('timecard__wage_premiums', function (Blueprint $table) {
            $table->id();
            // $table->string('fraction')->default('切り上げ');
            // $table->string('pay_unit')->default(1);
            $table->string('overtime_rate')->default(25);
            $table->string('night_rate')->default(25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timecard__wage_premiums');
    }
};
