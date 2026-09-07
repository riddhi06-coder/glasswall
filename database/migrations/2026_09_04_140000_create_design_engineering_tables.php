<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('design_engineerings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading');
            $table->string('banner_image');
            $table->string('section_heading');
            $table->longText('description');
            $table->string('features_heading');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('design_engineering_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('design_engineering_id')->constrained('design_engineerings')->cascadeOnDelete();
            $table->string('feature');
            $table->longText('description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('design_engineering_features');
        Schema::dropIfExists('design_engineerings');
    }
};
