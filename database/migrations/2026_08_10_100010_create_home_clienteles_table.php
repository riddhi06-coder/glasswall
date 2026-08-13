<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_clienteles', function (Blueprint $table) {
            $table->id();

            // Section headings
            $table->string('product_section_heading');
            $table->string('work_section_heading');
            $table->string('project_section_heading');

            // Clientele section
            $table->string('clientele_section_heading');
            $table->text('clientele_section_desc');

            // Collaboration section
            $table->string('collaboration_section_heading');
            $table->string('collaboration_section_title');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_clienteles');
    }
};
