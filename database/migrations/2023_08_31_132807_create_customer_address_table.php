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
        Schema::create('customer_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('fullname');
            $table->string('phone');
            $table->string('province');
            $table->integer('province_code');
            $table->string('district');
            $table->integer('district_code');
            $table->string('wards');
            $table->integer('wards_code');
            $table->string('address');
            $table->tinyInteger('selected')->default(0)->comment('0=>non-selected,1=>selected');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_address');
    }
};
