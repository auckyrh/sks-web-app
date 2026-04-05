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
        Schema::create('event_periods', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique();
            $table->string('theme');
            $table->string('event_logo')->nullable();
            $table->boolean('is_active')->default(false);
            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();
            $table->dateTime('registration_open_at')->nullable();
            $table->dateTime('registration_close_at')->nullable();
            $table->integer('max_participants')->default(350);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_periods');
    }
};
