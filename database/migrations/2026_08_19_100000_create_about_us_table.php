<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();

            // Banner / top section
            $table->string('banner_heading');
            $table->string('banner_video');
            $table->string('section_heading');
            $table->string('section_image');
            $table->text('description');

            // Vision section wrapper
            $table->string('vision_section_heading');
            $table->text('vision_section_description');

            // Vision block
            $table->string('vision_logo');
            $table->string('vision_heading');
            $table->string('vision_title');
            $table->text('vision_desc');
            $table->string('vision_image');

            // Mission block
            $table->string('mission_logo');
            $table->string('mission_heading');
            $table->string('mission_title');
            $table->text('mission_desc');
            $table->string('mission_image');

            // Core values section
            $table->string('core_title');
            $table->text('core_description');
            $table->string('core_image');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
