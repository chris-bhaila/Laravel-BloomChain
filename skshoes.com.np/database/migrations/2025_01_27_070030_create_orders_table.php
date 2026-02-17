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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('customer_name');
            $table->string('article_id');
            $table->string('shoe_name');
            $table->json('product_grouping')->nullable();
            $table->Integer('size')->unsigned();
            $table->string('address');
            $table->string('nearest_landmark')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('status');
            $table->string('price');
            $table->string('discount_code')->nullable();
            $table->float('discounted_price')->nullable();
            $table->string('payment_method');
            $table->text('transactionId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
