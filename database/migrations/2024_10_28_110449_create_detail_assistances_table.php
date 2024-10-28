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
        Schema::create('detail_assistances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assistance_id');
            $table->date('input_date');
            $table->tinyInteger('type');
            $table->json('additional_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_assistances');
    }
};
