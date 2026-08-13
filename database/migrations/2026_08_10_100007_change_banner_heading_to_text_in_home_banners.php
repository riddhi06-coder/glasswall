<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Banner heading now holds rich-text (CKEditor) HTML, so widen it.
        Schema::table('home_banners', function (Blueprint $table) {
            $table->text('banner_heading')->change();
        });
    }

    public function down(): void
    {
        Schema::table('home_banners', function (Blueprint $table) {
            $table->string('banner_heading')->change();
        });
    }
};
