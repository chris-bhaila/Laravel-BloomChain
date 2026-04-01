<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN subscription_type ENUM('general', 'premium', 'admin') NOT NULL DEFAULT 'general'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE users SET subscription_type = 'general' WHERE subscription_type = 'admin'");
        DB::statement("ALTER TABLE users MODIFY COLUMN subscription_type ENUM('general', 'premium') NOT NULL DEFAULT 'general'");
    }
};
