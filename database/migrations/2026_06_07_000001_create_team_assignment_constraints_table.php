<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_assignment_constraints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained()->cascadeOnDelete();

            // 'same_team'  → these registration numbers must land in the same team
            // 'fixed_team' → these registration numbers must land in a specific team
            $table->enum('type', ['same_team', 'fixed_team']);

            // e.g. ["SKS-2026-0280", "SKS-2026-0281"]
            $table->json('registration_numbers');

            // Only used when type = 'fixed_team'
            $table->foreignId('fixed_team_id')
                ->nullable()
                ->constrained('teams')
                ->nullOnDelete();

            // Human-readable reason — important for future reference each year
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_assignment_constraints');
    }
};
