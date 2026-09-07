<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->unsignedInteger('priority')->default(0)->after('is_active');
        });
        Schema::table('product_listings', function (Blueprint $table) {
            $table->unsignedInteger('priority')->default(0)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
        Schema::table('product_listings', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};
