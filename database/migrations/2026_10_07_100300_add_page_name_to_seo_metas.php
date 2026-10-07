<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seo_metas', function (Blueprint $table) {
            $table->string('page_name')->nullable()->after('url_path');
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('seo_metas', 'page_name')) {
            Schema::table('seo_metas', function (Blueprint $table) {
                $table->dropColumn('page_name');
            });
        }
    }
};
