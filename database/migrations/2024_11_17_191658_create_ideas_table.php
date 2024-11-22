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
        
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('category', ['Full stack Website', 'AI SaaS', 'Cloud/DevOps', 'Business Model', 'DevOps & CI/CD Pipelines', 'Augmented Reality (AR) & Virtual Reality (VR)','Blockchain & Cryptocurrency', 'Machine Learning & AI'])->default('Full stack Website'); // Category as enum
            $table->enum('idea_type', ['Tech & Development', 'Business & Marketing', 'Startup'])->default('Tech & Development');
            $table->enum('working_on_it', ['Yes', 'No'])->default('No');
            $table->text('description');
            $table->string('relevant_links')->nullable();
            $table->json('tags')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('view_count')->default(0);
            $table->integer('upvotes')->default(0);
            $table->integer('saves')->default(0);
            $table->integer('downvotes')->default(0);
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
