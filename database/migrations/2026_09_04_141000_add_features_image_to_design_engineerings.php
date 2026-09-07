<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('design_engineerings', function (Blueprint $table) {
            $table->string('features_image')->nullable()->after('features_heading');
        });
    }

    public function down(): void
    {
        Schema::table('design_engineerings', function (Blueprint $table) {
            $table->dropColumn('features_image');
        });
    }
};
