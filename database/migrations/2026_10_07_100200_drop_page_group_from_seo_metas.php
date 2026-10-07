<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('seo_metas', 'page_group')) {
            Schema::table('seo_metas', function (Blueprint $table) {
                $table->dropColumn('page_group');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('seo_metas', 'page_group')) {
            Schema::table('seo_metas', function (Blueprint $table) {
                $table->string('page_group')->nullable()->after('url_path');
            });
        }
    }
};
