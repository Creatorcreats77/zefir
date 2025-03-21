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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gender_id')->index()->nullable();
            $table->foreign('gender_id')->references('id')->on('genders')->nullOnDelete();
            $table->unsignedBigInteger('grandparent_id')->index()->nullable();
            $table->foreign('grandparent_id')->references('id')->on('categories')->nullOnDelete();
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->index();
            $table->unsignedInteger('sort_order')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
