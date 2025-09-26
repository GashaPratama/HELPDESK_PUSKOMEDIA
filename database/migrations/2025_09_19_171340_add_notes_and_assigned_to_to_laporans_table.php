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
            $table->text('notes')->nullable()->after('status');
            $table->unsignedBigInteger('assigned_to')->nullable()->after('notes');
            $table->foreign('assigned_to')->references('id_user')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['notes', 'assigned_to']);
        });
    }
};
