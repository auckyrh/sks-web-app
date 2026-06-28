<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained('event_periods');
            $table->enum('respondent_type', ['orang_tua', 'panitia']);
            $table->foreignId('event_class_id')->nullable()->constrained('event_classes');
            $table->string('respondent_name')->nullable();
            $table->string('respondent_phone')->nullable();
            $table->text('impressions')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
