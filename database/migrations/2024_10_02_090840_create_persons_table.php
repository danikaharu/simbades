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
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id');
            $table->string('family_card');
            $table->string('identification_number');
            $table->string('name');
            $table->tinyInteger('gender');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->tinyInteger('religion');
            $table->tinyInteger('kinship');
            $table->string('father_name');
            $table->string('mother_name');
            $table->tinyInteger('last_education');
            $table->tinyInteger('main_job');
            $table->string('income_month');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persons');
    }
};
