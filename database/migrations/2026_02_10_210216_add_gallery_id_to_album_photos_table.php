<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('album_photos', function (Blueprint $table) {
            $table->foreignId('gallery_id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('album_photos', function (Blueprint $table) {
            $table->dropForeign(['gallery_id']);
            $table->dropColumn('gallery_id');
        });
    }
};
