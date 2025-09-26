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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('background_image')->nullable()->after('address');
            $table->enum('background_type', ['gradient', 'image', 'solid'])->default('gradient')->after('background_image');
            $table->string('background_color', 7)->nullable()->after('background_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['background_image', 'background_type', 'background_color']);
        });
    }
};
