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
        Schema::create('house_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id');
            $table->string('building_area');
            $table->string('floor_material');
            $table->string('wall_material');
            $table->string('electricity_source');
            $table->string('electricity_capacity');
            $table->string('water_source');
            $table->string('cooking_fuel');
            $table->string('sanitation_facility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_conditions');
    }
};
