<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('career_details', function (Blueprint $table) {
            $table->dropColumn(['join_heading', 'short_desc']);
        });
    }

    public function down(): void
    {
        Schema::table('career_details', function (Blueprint $table) {
            $table->string('join_heading')->nullable();
            $table->string('short_desc', 1000)->nullable();
        });
    }
};
