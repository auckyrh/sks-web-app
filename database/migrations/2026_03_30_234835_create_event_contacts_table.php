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
        Schema::create('event_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained('event_periods')->cascadeOnDelete();
            $table->string('category'); // e.g. Informasi Umum, Pendaftaran, Konsumsi
            $table->string('name');     // person's name
            $table->string('whatsapp');       // whatsapp number
            $table->string('role')->nullable(); // e.g. Koordinator Pendaftaran
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_contacts');
    }
};
