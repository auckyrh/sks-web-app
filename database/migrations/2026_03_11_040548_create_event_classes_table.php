<?php

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
        Schema::create('event_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained()->cascadeOnDelete();
            $table->enum('level', ['kecil', 'tengah', 'besar']);
            $table->string('saint_name');
            $table->tinyInteger('grade_min');
            $table->tinyInteger('grade_max');
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_classes');
    }
};
