<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'title')) {
                $table->string('title');
            }

            if (!Schema::hasColumn('galleries', 'category_id')) {
                $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('galleries', 'album_id')) {
                $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            }

            if (!Schema::hasColumn('galleries', 'description')) {
                $table->text('description')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('galleries', 'description')) {
                $table->dropColumn('description');
            }
            if (Schema::hasColumn('galleries', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('galleries', 'album_id')) {
                $table->dropForeign(['album_id']);
                $table->dropColumn('album_id');
            }
        });
    }
};
