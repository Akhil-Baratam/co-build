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
        Schema::create('ideathons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // References the company (user_id)
            $table->string('title'); // Ideathon title
            $table->text('description'); // Description of the ideathon
            $table->json('requirement_links')->nullable(); // List of requirement links
            $table->json('tags')->nullable(); // Tags for search/filter
            $table->dateTime('submission_deadline'); // Deadline for submissions
            $table->timestamps();
        
            $table->foreign('company_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideathons');
    }
};
