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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('event_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_class_id')->nullable()->constrained('event_classes')->nullOnDelete();
            $table->string('child_full_name');
            $table->string('nickname');
            $table->enum('gender', ['M', 'F']);
            $table->date('birth_date');
            $table->tinyInteger('grade');
            $table->string('parent_name');
            $table->string('parent_wa');
            $table->string('tshirt_size');
            $table->string('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
