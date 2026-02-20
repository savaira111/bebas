<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'image')) {
                $table->string('image')->nullable()->after('title');
            }
            if (!Schema::hasColumn('galleries', 'video_url')) {
                $table->string('video_url')->nullable()->after('image');
            }
            // Ensure type column is string/enum correctly
            if (!Schema::hasColumn('galleries', 'type')) {
                $table->string('type')->default('foto')->after('video_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'video_url')) {
                $table->dropColumn('video_url');
            }
        });
    }
};
