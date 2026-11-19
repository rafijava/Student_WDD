<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'course_id' => 'CRS-'.fake()->unique()->numberBetween(100, 999),
            'title'     => fake()->sentence(3),
            'capacity'  => fake()->numberBetween(10, 50),
            'fee'       => fake()->randomFloat(2, 1000, 50000),
        ];
    }
}
