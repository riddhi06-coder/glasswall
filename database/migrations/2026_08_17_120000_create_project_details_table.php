<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_listing_id')->constrained('project_listings')->cascadeOnDelete();
            $table->string('banner_image');
            $table->string('image');
            $table->string('client');
            $table->string('architect');
            $table->string('consultant');
            $table->string('project_area');
            $table->string('floors');
            $table->json('scope_of_work')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};
