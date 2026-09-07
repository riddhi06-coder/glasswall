<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_details', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading');
            $table->string('banner_image');
            $table->string('section_heading');
            $table->string('section_image');
            $table->longText('description');
            $table->string('join_heading');
            $table->text('short_desc');
            $table->string('job_section_heading');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_details');
    }
};
