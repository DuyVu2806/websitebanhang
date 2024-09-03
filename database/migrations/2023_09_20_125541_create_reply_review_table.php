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
        Schema::create('reply_review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('review_id');
            $table->bigInteger('reply_customer_id');
            $table->string('comment');
            $table->string('name')->default('Quản trị viên');
            $table->timestamps();

            $table->foreign('review_id')->references('id')->on('review');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reply_review');
    }
};
