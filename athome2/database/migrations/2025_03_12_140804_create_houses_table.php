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
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('houseName');
            $table->string('housetype');
            $table->string('street');
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->integer('total_occupants');
            $table->integer('total_rooms');
            $table->integer('total_bathrooms');
            $table->text('description');
            $table->boolean('has_aircon');
            $table->boolean('has_kitchen');
            $table->boolean('has_wifi');
            $table->boolean('has_parking');
            $table->boolean('has_gym');
            $table->boolean('electric_meter');
            $table->boolean('water_meter');
            $table->float('price');
            $table->boolean('status')->default('1');

            // Foreign key constraint
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->ondelete('cascade');
           });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};