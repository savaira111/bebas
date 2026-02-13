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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->text('description')->nullable()->after('name');
            $table->string('image')->nullable()->after('description');
            $table->decimal('price', 15, 2)->after('image'); // Use decimal for currency
            $table->foreignId('category_id')->after('price')->constrained()->onDelete('cascade');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['name', 'description', 'image', 'price', 'category_id', 'deleted_at']);
        });
    }
};
