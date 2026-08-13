<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_about_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_about_id')->constrained('home_abouts')->cascadeOnDelete();
            $table->string('icon');          // stored filename
            $table->string('count');         // free text, e.g. "500000+"
            $table->string('milestone');     // label, e.g. "Projects Completed"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_about_milestones');
    }
};
