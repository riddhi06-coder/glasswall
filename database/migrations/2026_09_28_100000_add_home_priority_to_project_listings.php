<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_listings', function (Blueprint $table) {
            $table->unsignedInteger('home_priority')->nullable()->after('show_on_home');
        });

        // Backfill: number the projects already shown on home 1..n within each category.
        $rows = DB::table('project_listings')
            ->where('show_on_home', true)
            ->whereNull('deleted_at')
            ->orderBy('project_category_id')
            ->orderBy('priority')
            ->orderBy('id')
            ->get(['id', 'project_category_id']);

        $counters = [];
        foreach ($rows as $row) {
            $counters[$row->project_category_id] = ($counters[$row->project_category_id] ?? 0) + 1;
            DB::table('project_listings')->where('id', $row->id)->update(['home_priority' => $counters[$row->project_category_id]]);
        }
    }

    public function down(): void
    {
        Schema::table('project_listings', function (Blueprint $table) {
            $table->dropColumn('home_priority');
        });
    }
};
