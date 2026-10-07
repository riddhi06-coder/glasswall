<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Singleton page settings (banner + intro heading)
        Schema::create('disclosures', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading')->default('Disclosures');
            $table->string('banner_image')->nullable();
            $table->text('page_heading')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Each numbered disclosure row
        Schema::create('disclosure_rows', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();           // "01", "14", "15"
            $table->text('title')->nullable();               // row title / financial heading
            $table->enum('type', ['links', 'financial', 'tabs'])->default('links');
            $table->string('year')->nullable();              // for financial / tabs
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Links (used by "links" rows and by "financial" sub-items)
        Schema::create('disclosure_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disclosure_row_id')->constrained('disclosure_rows')->cascadeOnDelete();
            $table->text('name')->nullable();                // financial sub-item text (a/b/c); null for plain links
            $table->string('label')->default('View');        // link text
            $table->string('url')->nullable();                // external URL / path
            $table->string('file')->nullable();               // uploaded PDF filename
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Quarter tabs (for "tabs" rows)
        Schema::create('disclosure_tabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disclosure_row_id')->constrained('disclosure_rows')->cascadeOnDelete();
            $table->string('label')->default('Q1');           // tab button text
            $table->text('content')->nullable();              // tab body (rich text / "Coming Soon")
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disclosure_tabs');
        Schema::dropIfExists('disclosure_links');
        Schema::dropIfExists('disclosure_rows');
        Schema::dropIfExists('disclosures');
    }
};
