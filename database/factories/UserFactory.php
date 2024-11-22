<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // default password
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(['individual', 'company']),
            'image' => $this->faker->imageUrl(200, 200), // Dummy image URL
            'designation' => $this->faker->word,
            'bio' => $this->faker->sentence,
            'portfolio' => $this->faker->url,
            'github' => $this->faker->url,
            'mobile' => $this->faker->phoneNumber,
            'company_name' => $this->faker->company,  // If role is 'company', you can populate this field
            'website' => $this->faker->url,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
