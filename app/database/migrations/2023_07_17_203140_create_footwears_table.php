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
        Schema::create('footwears', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->string('image');
            $table->foreignId('user_id');
            $table->double('total_km')->default('0');
            $table->double('total_time')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footwears');
    }
};
