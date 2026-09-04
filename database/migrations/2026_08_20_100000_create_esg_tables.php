<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('esgs', function (Blueprint $table) {
            $table->id();

            // Banner
            $table->string('banner_heading');
            $table->string('banner_image');

            // Director Message
            $table->string('director_image');
            $table->string('director_heading');
            $table->text('director_desc');
            $table->string('director_name');
            $table->string('director_position');

            // Innovation
            $table->string('innovation_heading');
            $table->string('innovation_bg_image');

            // Development Goals
            $table->string('dev_heading');
            $table->string('dev_image');
            $table->text('dev_desc');

            // Driving Change
            $table->string('driving_heading');
            $table->string('driving_bg_image');

            // Impact
            $table->string('impact_heading');

            // Stakeholder
            $table->string('stakeholder_heading');
            $table->string('stakeholder_image');
            $table->text('stakeholder_desc');

            // Waste
            $table->string('waste_heading');
            $table->text('waste_desc');

            // Environmental Declarations
            $table->string('env_heading');
            $table->text('env_short_desc');
            $table->text('env_specification_desc');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Innovation feature rows (image / feature / description)
        Schema::create('esg_innovation_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esg_id')->constrained('esgs')->cascadeOnDelete();
            $table->string('image');
            $table->string('feature');
            $table->text('description');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Driving-change count rows (image / count / feature)
        Schema::create('esg_driving_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esg_id')->constrained('esgs')->cascadeOnDelete();
            $table->string('image');
            $table->string('count');
            $table->string('feature');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Impact rows (image / year / impact / description)
        Schema::create('esg_impacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esg_id')->constrained('esgs')->cascadeOnDelete();
            $table->string('image');
            $table->string('year');
            $table->string('impact');
            $table->text('description');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Waste feature rows (image / feature / description)
        Schema::create('esg_waste_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('esg_id')->constrained('esgs')->cascadeOnDelete();
            $table->string('image');
            $table->string('feature');
            $table->text('description');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esg_waste_features');
        Schema::dropIfExists('esg_impacts');
        Schema::dropIfExists('esg_driving_counts');
        Schema::dropIfExists('esg_innovation_features');
        Schema::dropIfExists('esgs');
    }
};
