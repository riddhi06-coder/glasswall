<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->text('about_heading')->nullable()->after('banner_image');
        });
        Schema::table('facility_galleries', function (Blueprint $table) {
            $table->string('heading')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn('about_heading');
        });
        Schema::table('facility_galleries', function (Blueprint $table) {
            $table->dropColumn('heading');
        });
    }
};
