<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_managements', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading');
            $table->string('banner_image');
            $table->longText('description');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_management_pointers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_management_id')->constrained('project_managements')->cascadeOnDelete();
            $table->text('pointer');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_management_pointers');
        Schema::dropIfExists('project_managements');
    }
};
