<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_clientele_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_clientele_id')->constrained('home_clienteles')->cascadeOnDelete();
            $table->string('image');         // stored filename
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_clientele_images');
    }
};
