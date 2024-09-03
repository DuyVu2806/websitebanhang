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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('province');
            $table->integer('province_code');
            $table->string('district');
            $table->integer('district_code');
            $table->string('wards');
            $table->integer('wards_code');
            $table->string('address');
            $table->integer('total_price');
            $table->integer('status_message')->default(0)->comment('0=> đặt thành công, 1=>xác nhận đơn hàng, 2=>đang vận chuyển, 3=>giao hàng thành công,4=>hủy đơn hàng');
            $table->string('payment_mode');
            $table->integer('payment_id')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
