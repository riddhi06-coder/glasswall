<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipo_drhps', function (Blueprint $table) {
            $table->id();
            $table->string('page1_heading');
            $table->longText('page1_content');
            $table->string('page2_heading');
            $table->longText('page2_content');
            $table->string('pdf');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipo_drhps');
    }
};
