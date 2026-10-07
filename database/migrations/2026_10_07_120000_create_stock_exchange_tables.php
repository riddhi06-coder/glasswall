<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_exchanges', function (Blueprint $table) {
            $table->id();
            $table->string('banner_heading')->default('Stock Exchange');
            $table->string('banner_image')->nullable();
            $table->string('page_heading')->nullable();   // e.g. "Financial Year 2026-2027"
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('stock_exchange_tabs', function (Blueprint $table) {
            $table->id();
            $table->string('label')->default('Q1');       // tab button text
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('stock_exchange_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_exchange_tab_id')->constrained('stock_exchange_tabs')->cascadeOnDelete();
            $table->string('number')->nullable();
            $table->text('title')->nullable();
            $table->string('url')->nullable();
            $table->string('file')->nullable();            // uploaded PDF
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_exchange_items');
        Schema::dropIfExists('stock_exchange_tabs');
        Schema::dropIfExists('stock_exchanges');
    }
};
