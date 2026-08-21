<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('awards_recognitions', function (Blueprint $table) {
            $table->id();

            // Page banner — only kept on the first record.
            $table->string('banner_heading')->nullable();
            $table->string('banner_image')->nullable();

            // Per-award details.
            $table->foreignId('awards_category_id')->constrained('awards_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('subject');
            $table->string('year');
            $table->string('thumbnail_image');
            $table->string('main_image');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('awards_recognitions');
    }
};
