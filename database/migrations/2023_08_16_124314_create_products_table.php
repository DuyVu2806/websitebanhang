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
            $table->integer('product_code');
            $table->string('name');
            $table->string('slug');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('image');
            $table->mediumText('small_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('quantity')->default('0');
            $table->integer('price');
            $table->tinyInteger('status')->default('0')->comment('1=hidden,0=visible');
            $table->boolean('is_new')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->integer('height')->comment('cm');
            $table->integer('weight')->comment('gram');
            $table->integer('width')->comment('cm');
            $table->integer('length')->comment('cm');
            $table->double('rating')->default(0);
            $table->softDeletes();

            $table->foreign('brand_id')->references('id')->on('brand');
            $table->foreign('category_id')->references('id')->on('category');
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
