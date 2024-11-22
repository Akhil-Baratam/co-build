<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *

     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keywords = ['AI', 'Blockchain', 'Machine Learning', 'SaaS', 'Cloud', 'AR', 'VR', 'Web Development', 'IoT', 'Cybersecurity'];

        // Randomly select some keywords for title and tags
        $titleKeywords = $this->faker->randomElements($keywords, 2); // Randomly pick 2 keywords for the title
        $tagKeywords = $this->faker->randomElements($keywords, 3);  // Randomly pick 3 keywords for tags
    
        // Create the title by joining the random keywords with additional words
        $title = $titleKeywords[0] . ' and ' . $titleKeywords[1] . ' Development';

        // Get a random user for the idea
        $user = User::inRandomOrder()->first();  // Ensure this user exists before assigning

        return [
            'title' => $title,
            'category' => $this->faker->randomElement([
                'Full stack Website',
                'AI SaaS',
                'Cloud/DevOps',
                'Business Model',
                'DevOps & CI/CD Pipelines',
                'Augmented Reality (AR) & Virtual Reality (VR)',
                'Blockchain & Cryptocurrency',
                'Machine Learning & AI',
            ]),
            'idea_type' => $this->faker->randomElement([
                'Tech & Development',
                'Business & Marketing',
                'Startup'
            ]),
            'working_on_it' => $this->faker->randomElement(['Yes', 'No']),
            'description' => $this->faker->paragraph,
            'relevant_links' => $this->faker->url,
            'tags' => json_encode($tagKeywords),
            'user_id' => $user ? $user->id : null,  // Ensure a random user is assigned
            'view_count' => $this->faker->numberBetween(0, 100),
            'upvotes' => $this->faker->numberBetween(0, 50),
            'saves' => $this->faker->numberBetween(0, 20),
            'downvotes' => $this->faker->numberBetween(0, 10),
            'last_updated_by' => $user ? $user->id : null,  // Optional last updated user
        ];
    }
}
