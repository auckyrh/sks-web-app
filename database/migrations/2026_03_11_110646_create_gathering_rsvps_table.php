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
        Schema::create('gathering_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gathering_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('will_attend', ['yes', 'no', 'maybe'])->default('maybe');
            $table->dateTime('responded_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['gathering_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gathering_rsvps');
    }
};
