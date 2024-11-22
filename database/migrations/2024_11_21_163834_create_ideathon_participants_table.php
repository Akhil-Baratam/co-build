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
        Schema::create('ideathon_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ideathon_id'); // References the ideathon
            $table->unsignedBigInteger('user_id'); // References the user who joined
            $table->timestamps();
        
            $table->foreign('ideathon_id')->references('id')->on('ideathons')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            // Prevent duplicate participation
            $table->unique(['ideathon_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideathon_participants');
    }
};
