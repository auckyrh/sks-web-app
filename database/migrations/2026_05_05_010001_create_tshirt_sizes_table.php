<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tshirt_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_period_id')->constrained()->cascadeOnDelete();
            $table->string('code');                          // 'S', 'XL', 'M-Dewasa', etc.
            $table->string('label');                         // 'S (Anak)', 'M Dewasa', etc.
            $table->enum('category', ['kids', 'adult']);
            $table->unsignedSmallInteger('panjang');         // height in cm
            $table->unsignedSmallInteger('lebar');           // width in cm
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['event_period_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tshirt_sizes');
    }
};
