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
        Schema::create('discounts', function (Blueprint $table) {
            $table->string('discount_code')->primary();
            $table->integer('percentage')->unsigned()->check('percentage <= 100');
            $table->integer('maximum_use')->unsigned();
            $table->integer('use_count')->unsigned();
            $table->integer('maximum_amount')->unsigned();
            $table->date('expiry_date');
            $table->string('article_id')->nullable();
            $table->foreign('article_id')->references('article_id')->on('shoes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('category_name')->nullable();
            $table->foreign('category_name')->references('category_name')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status');               
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
