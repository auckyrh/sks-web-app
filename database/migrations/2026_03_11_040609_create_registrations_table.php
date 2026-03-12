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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained()->cascadeOnDelete();
            $table->string('registration_number')->unique();
            $table->string('child_full_name');
            $table->string('nickname');
            $table->enum('gender', ['M', 'F']);
            $table->date('birth_date');
            $table->string('address');
            $table->foreignId('wilayah_id')->constrained('wilayahs')->restrictOnDelete();
            $table->foreignId('lingkungan_id')->nullable()->constrained('lingkungans')->nullOnDelete();
            $table->tinyInteger('grade');
            $table->enum('registration_source', ['BIAK', 'YCK', 'UMUM']);
            $table->boolean('has_joined_biak_yck')->default(false);
            $table->enum('tshirt_size', ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL']);
            $table->string('parent_name');
            $table->string('parent_wa');
            $table->string('allergies')->nullable();
            $table->text('notes')->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->foreignId('payment_tier_id')->nullable()->constrained('payment_tiers')->nullOnDelete();
            $table->integer('payment_amount')->nullable();
            $table->enum('payment_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
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
        Schema::dropIfExists('registrations');
    }
};
