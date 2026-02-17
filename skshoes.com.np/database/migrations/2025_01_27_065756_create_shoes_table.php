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
        Schema::create('shoes', function (Blueprint $table) {
            $table->string('article_id', 255)->primary();
            $table->string('shoe_name');
            $table->string('shoe_color');
            $table->string('shoe_image1');
            $table->string('shoe_image2')->nullable();
            $table->string('shoe_image3')->nullable();
            $table->string('shoe_image4')->nullable();
            $table->string('shoe_image5')->nullable();
            $table->string('shoe_image6')->nullable();
            $table->string('shoe_video')->nullable();
            $table->text('shoe_description');
            $table->string('category_name');
            $table->foreign('category_name')->references('category_name')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shoes');
    }
};
