<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_details', function (Blueprint $table) {
            $table->string('banner_heading')->after('id');
            $table->string('banner_image')->after('banner_heading');
        });
    }

    public function down(): void
    {
        Schema::table('contact_details', function (Blueprint $table) {
            $table->dropColumn(['banner_heading', 'banner_image']);
        });
    }
};
