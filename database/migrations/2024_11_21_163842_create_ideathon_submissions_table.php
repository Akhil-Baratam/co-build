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
        Schema::create('ideathon_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id'); // References the participant
            $table->text('submission_link'); // Submission link provided by the participant
            $table->text('note')->nullable(); // Optional note
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Submission status
            $table->timestamps();
        
            $table->foreign('participant_id')->references('id')->on('ideathon_participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideathon_submissions');
    }
};
