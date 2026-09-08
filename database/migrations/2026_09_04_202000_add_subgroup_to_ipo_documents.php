<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ipo_documents', function (Blueprint $table) {
            $table->string('subgroup')->nullable()->after('group');
            $table->boolean('is_group_header')->default(false)->after('subgroup');
        });
    }

    public function down(): void
    {
        Schema::table('ipo_documents', function (Blueprint $table) {
            $table->dropColumn(['subgroup', 'is_group_header']);
        });
    }
};
