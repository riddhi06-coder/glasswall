<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            // Section 01 — In-House Façade Testing Facility
            $table->string('testing_heading')->nullable();
            $table->longText('testing_content')->nullable();
            $table->string('testing_image1')->nullable();
            $table->string('testing_image2')->nullable();
            // Section 02 — calibration text + images
            $table->longText('testing2_content')->nullable();
            $table->string('testing2_image1')->nullable();
            $table->string('testing2_image2')->nullable();
            // Section 03 — NABL certification
            $table->string('nabl_heading')->nullable();
            $table->string('nabl_image')->nullable();
            // Section 04 — Precision Engineering
            $table->string('precision_heading')->nullable();
            $table->longText('precision_content')->nullable();
            // Section 05 — Project testing mock-ups
            $table->string('mockup_caption')->nullable();
            $table->string('mockup_image1')->nullable();
            $table->string('mockup_image2')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn([
                'testing_heading', 'testing_content', 'testing_image1', 'testing_image2',
                'testing2_content', 'testing2_image1', 'testing2_image2',
                'nabl_heading', 'nabl_image',
                'precision_heading', 'precision_content',
                'mockup_caption', 'mockup_image1', 'mockup_image2',
            ]);
        });
    }
};
