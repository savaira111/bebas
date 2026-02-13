<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('albums')) {
            Schema::create('albums', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('cover_image')->nullable();
                $table->softDeletes(); // WAJIB ADA UNTUK SOFT DELETE
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('albums');
    }
};