<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE plants MODIFY COLUMN category
            ENUM('flowering', 'succulents', 'herbs', 'trees', 'aquatic', 'bonsai', 'foliage')
            NULL"); //DB because Laravel has a hard time dealing with ENUMs
        DB::statement("ALTER TABLE plants MODIFY COLUMN sunlight_requirement
            ENUM('full_sun', 'partial_shade', 'full_shade')
            NULL");
        DB::statement("ALTER TABLE plants MODIFY COLUMN water_requirement
            ENUM('low', 'moderate', 'high')
            NULL");
        DB::statement("ALTER TABLE plants MODIFY COLUMN best_season
            ENUM('summer', 'autumn', 'winter', 'spring')
            NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE plants MODIFY COLUMN category VARCHAR(255) NULL");
        DB::statement("ALTER TABLE plants MODIFY COLUMN sunlight_requirement VARCHAR(255) NULL");
        DB::statement("ALTER TABLE plants MODIFY COLUMN water_requirement VARCHAR(255) NULL");
        DB::statement("ALTER TABLE plants MODIFY COLUMN best_season VARCHAR(255) NULL");
    }
};
