<?php
use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        Job::create([
            'title' => 'Software Engineer',
            'description' => 'Develop and maintain software applications.',
            'location' => 'New York',
        ]);

        Job::create([
            'title' => 'Web Developer',
            'description' => 'Build and maintain websites.',
            'location' => 'San Francisco',
        ]);

        // Add more jobs as needed
    }
}