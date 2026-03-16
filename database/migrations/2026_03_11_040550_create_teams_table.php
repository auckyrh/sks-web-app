<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained('event_periods')->cascadeOnDelete();
            $table->foreignId('event_class_id')->constrained('event_classes')->cascadeOnDelete();
            $table->integer('number');
            $table->string('name');
            $table->timestamps();

            $table->unique(['event_class_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
