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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedBigInteger('gender_id')->index()->nullable();
            $table->foreign('gender_id')->references('id')->on('genders')->nullOnDelete();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->unsignedBigInteger('brand_id')->index();
            $table->foreign('brand_id')->references('id')->on('brands')->cascadeOnDelete();
            $table->unsignedBigInteger('color_id')->index();
            $table->foreign('color_id')->references('id')->on('attribute_values')->cascadeOnDelete();
            $table->unsignedBigInteger('home_category_id')->index()->nullable();
            $table->foreign('home_category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->string('group_id')->index();
            $table->string('product_id')->index();
            $table->string('name');
            $table->string('slug')->index();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->double('discounted_price')->default(0);
            $table->double('selling_price')->default(0);
            $table->boolean('has_discount')->default(0);
            $table->boolean('has_stock')->default(0);
            $table->unsignedInteger('viewed')->default(0);
            $table->unsignedInteger('random')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
