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
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_item_id');
            $table->double('rating');
            $table->string('outstanding_feature')->default('None');
            $table->string('collection')->default('None');
            $table->string('comment')->default('None');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer');
            $table->foreign('order_item_id')->references('id')->on('order_detail');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review');
    }
};
