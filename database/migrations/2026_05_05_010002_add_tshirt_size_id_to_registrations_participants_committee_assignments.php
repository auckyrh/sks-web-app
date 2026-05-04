<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('tshirt_size_id')
                ->nullable()
                ->after('tshirt_size')
                ->constrained('tshirt_sizes')
                ->nullOnDelete();
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->foreignId('tshirt_size_id')
                ->nullable()
                ->after('tshirt_size')
                ->constrained('tshirt_sizes')
                ->nullOnDelete();
        });

        Schema::table('committee_assignments', function (Blueprint $table) {
            $table->foreignId('tshirt_size_id')
                ->nullable()
                ->after('is_active')
                ->constrained('tshirt_sizes')
                ->nullOnDelete();
            $table->text('notes')->nullable()->after('tshirt_size_id');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropForeign(['tshirt_size_id']);
            $table->dropColumn('tshirt_size_id');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropForeign(['tshirt_size_id']);
            $table->dropColumn('tshirt_size_id');
        });

        Schema::table('committee_assignments', function (Blueprint $table) {
            $table->dropForeign(['tshirt_size_id']);
            $table->dropColumn(['tshirt_size_id', 'notes']);
        });
    }
};
