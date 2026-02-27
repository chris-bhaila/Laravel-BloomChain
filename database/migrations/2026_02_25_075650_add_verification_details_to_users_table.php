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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email'); // phone number
            $table->enum('verification_status', ['unverified', 'verified', 'rejected'])
                ->default('unverified')
                ->after('phone'); // verification status
            $table->enum('subscription_type', ['general', 'premium'])
                ->default('general')
                ->after('verification_status'); // subscription type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'verification_status', 'subscription_type']);
        });
    }
};
