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
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('registration_summary_number')->unique();
            $table->string('landline_phone_number')->nullable();
            $table->string('accommodation_type')->nullable();
            $table->string('current_place_of_residence')->nullable();
            $table->string('monthly_rent_value')->nullable();
            $table->integer('block_number')->nullable();
            $table->integer('district_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
