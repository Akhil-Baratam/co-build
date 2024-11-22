<?php

namespace Database\Seeders;

use App\Models\Ideathon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdeathonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ideathon::create([
            'company_id' => 1,
            'title' => 'Tech Revolution Ideathon',
            'description' => 'Submit innovative ideas in AI and ML.',
            'requirement_links' => json_encode(['https://example.com/requirements']),
            'tags' => json_encode(['AI', 'ML', 'Innovation']),
            'submission_deadline' => now()->addDays(10),
        ]);
    }
}
