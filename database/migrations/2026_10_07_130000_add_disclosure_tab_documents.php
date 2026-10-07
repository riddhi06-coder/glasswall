<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disclosure_rows', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('number');
        });

        // Documents inside a quarterly tab (mirrors stock_exchange_items).
        Schema::create('disclosure_tab_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disclosure_tab_id')->constrained('disclosure_tabs')->cascadeOnDelete();
            $table->text('title')->nullable();
            $table->string('url')->nullable();
            $table->string('file')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disclosure_tab_items');
        if (Schema::hasColumn('disclosure_rows', 'slug')) {
            Schema::table('disclosure_rows', function (Blueprint $table) {
                $table->dropColumn('slug');
            });
        }
    }
};
