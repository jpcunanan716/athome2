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
        Schema::create('message_participants', function (Blueprint $table) {
            $table->increments('id'); // Primary key
            $table->integer('user_id')->unsigned();
            $table->integer('conversation_id')->unsigned();
            $table->boolean('is_read')->default(false);
            $table->timestamp('last_read_at')->nullable();
            
            // Foreign key constraints
            $table->foreign('conversation_id')->references('id')->on('conversations')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_participants');
    }
};
