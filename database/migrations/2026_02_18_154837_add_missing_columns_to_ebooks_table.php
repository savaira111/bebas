<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            if (!Schema::hasColumn('ebooks', 'author')) {
                $table->string('author')->nullable()->after('title');
            }
            if (!Schema::hasColumn('ebooks', 'description')) {
                $table->text('description')->nullable()->after('author');
            }
            if (Schema::hasColumn('ebooks', 'is_login_required')) {
                $table->dropColumn('is_login_required');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropColumn(['author', 'description']);
            $table->boolean('is_login_required')->default(false)->after('pdf');
        });
    }
};
