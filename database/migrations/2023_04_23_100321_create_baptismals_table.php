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
        Schema::create('baptismals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('godfather_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('godfather_id');
            $table->string('baptismal_place')->nullable();
            $table->date('baptismal_date')->nullable();
            $table->string('baptismal_record_number')->nullable();
            $table->string('page_number')->nullable();
            $table->string('baptized_father')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baptismals');
    }
};
