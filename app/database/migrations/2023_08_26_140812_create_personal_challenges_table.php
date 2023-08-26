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
        Schema::create('personal_challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->double('goal_value');
            $table->double('current_value');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('user_id');
            $table->boolean('complete');
            $table->boolean('expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_challenges');
    }
};
