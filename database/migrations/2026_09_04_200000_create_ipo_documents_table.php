<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipo_documents', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('title');
            $table->string('group')->nullable();
            $table->string('pdf');
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('priority')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipo_documents');
    }
};
