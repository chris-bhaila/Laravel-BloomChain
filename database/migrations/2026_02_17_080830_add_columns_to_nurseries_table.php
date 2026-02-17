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
            $table->string('reg_cer')->after('description'); // registration certificate filename
            $table->string('pan_cer')->after('reg_cer'); // PAN certificate filename
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nurseries', function (Blueprint $table) {
            $table->dropColumn(['reg_cer', 'pan_cer']);
        });
    }
};
