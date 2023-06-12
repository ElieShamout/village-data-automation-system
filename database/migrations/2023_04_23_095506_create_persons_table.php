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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable(); // not require
            $table->string('ID_number')->unique()->nullable(); // not require
            $table->string('birthdate_place')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('study_phase')->nullable();
            $table->string('academic_title')->nullable();
            $table->string('work')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('registration_place')->nullable();
            $table->boolean('immigration')->nullable();
            $table->boolean('military_service')->nullable();
            $table->boolean('live_dead')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
