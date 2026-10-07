<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();
            $table->string('url_path')->unique();           // normalized path, e.g. "/", "/about-us"
            $table->string('page_group')->nullable();        // e.g. "Main Pages" (for admin grouping)
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('canonical')->nullable();         // blank => current URL
            $table->text('hreflang')->nullable();            // raw <link rel="alternate" ...> markup
            $table->text('og_tag')->nullable();              // raw OG meta markup
            $table->text('twitter_card_tag')->nullable();    // raw Twitter card markup
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_metas');
    }
};
