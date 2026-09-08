<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->string('section_subtitle')->nullable()->after('video');
            $table->string('section_heading')->nullable()->after('section_subtitle');
            $table->text('section_intro')->nullable()->after('section_heading');
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['section_subtitle', 'section_heading', 'section_intro']);
        });
    }
};
