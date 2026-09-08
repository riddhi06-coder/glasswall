<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->string('job_role')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('contact_no');
            $table->text('message')->nullable();
            $table->string('resume_path');
            $table->string('resume_name');
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
