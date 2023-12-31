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
        Schema::create('family_persons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_id');
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('adjective'); // father , mother , child
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_persons');
    }
};
