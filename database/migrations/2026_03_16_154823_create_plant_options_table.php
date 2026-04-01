<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_options', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('value');
            $table->timestamps();
        });

        // Seed default values
        $options = [
            ['type' => 'category',            'value' => 'flowering'],
            ['type' => 'category',            'value' => 'succulents'],
            ['type' => 'category',            'value' => 'herbs'],
            ['type' => 'category',            'value' => 'trees'],
            ['type' => 'category',            'value' => 'aquatic'],
            ['type' => 'category',            'value' => 'bonsai'],
            ['type' => 'category',            'value' => 'foliage'],
            ['type' => 'best_season',         'value' => 'summer'],
            ['type' => 'best_season',         'value' => 'autumn'],
            ['type' => 'best_season',         'value' => 'winter'],
            ['type' => 'best_season',         'value' => 'spring'],
            ['type' => 'location',            'value' => 'indoor'],
            ['type' => 'location',            'value' => 'outdoor'],
            ['type' => 'location',            'value' => 'both'],
            ['type' => 'sunlight_requirement','value' => 'full_sun'],
            ['type' => 'sunlight_requirement','value' => 'partial_shade'],
            ['type' => 'sunlight_requirement','value' => 'full_shade'],
            ['type' => 'water_requirement',   'value' => 'low'],
            ['type' => 'water_requirement',   'value' => 'moderate'],
            ['type' => 'water_requirement',   'value' => 'high'],
        ];

        foreach ($options as $option) {
            DB::table('plant_options')->insert($option);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_options');
    }
};