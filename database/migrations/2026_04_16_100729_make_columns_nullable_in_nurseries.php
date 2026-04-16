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
        Schema::table('nurseries', function (Blueprint $table) {
            $table->string('reg_cer')->nullable()->change();
            $table->string('pan_cer')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nurseries', function (Blueprint $table) {
            $table->string('reg_cer')->nullable(false)->change();
            $table->string('pan_cer')->nullable(false)->change();
        });
    }
};
