<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            if (!Schema::hasColumn('articles', 'reviewer_note')) {
                $table->text('reviewer_note')->nullable()->after('content');
            }
        });

        // Assign existing articles to the first superadmin or admin
        $firstAdmin = DB::table('users')->whereIn('role', ['superadmin', 'admin'])->first();
        if ($firstAdmin) {
            DB::table('articles')->whereNull('user_id')->update(['user_id' => $firstAdmin->id]);
        } else {
            // If no admin yet, we might need a fallback or just leave it nullable for now.
            // But usually there is at least one admin.
        }
        
        // Use raw SQL to change enum to include both old and new values
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'publish', 'pending', 'published', 'rejected') DEFAULT 'draft'");
        
        // Update existing 'publish' to 'published'
        DB::table('articles')->where('status', 'publish')->update(['status' => 'published']);

        // Finalize enum to only new values
        DB::statement("ALTER TABLE articles MODIFY COLUMN status ENUM('draft', 'pending', 'published', 'rejected') DEFAULT 'draft'");
    }

    public function down(): void {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'reviewer_note']);
            $table->enum('status', ['draft', 'submit', 'publish'])->default('draft')->change();
        });
    }
};
