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
        Schema::create('engagments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('husband_id');
            $table->foreign('husband_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('wife_id');
            $table->foreign('wife_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('baptized_father');
            $table->string('record_number');
            $table->date('registration_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engagments');
    }
};
