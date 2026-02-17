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
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('price_id');
            $table->string('article_id', 255);
            $table->foreign('article_id')->references('article_id')->on('shoes')->onUpdate('cascade')->onDelete('cascade');
            $table->json('product_grouping')->nullable();
            $table->integer('price')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
