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
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('note_target_role')->nullable()->after('note');
            $table->string('note_from_role')->nullable()->after('note_target_role');
            $table->timestamp('note_created_at')->nullable()->after('note_from_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn(['note_target_role', 'note_from_role', 'note_created_at']);
        });
    }
};

