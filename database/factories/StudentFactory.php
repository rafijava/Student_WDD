<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'name'       => fake()->name(),
            'student_id' => 'STU-'.fake()->unique()->numberBetween(1000, 9999),
            'department' => fake()->randomElement(['CSE', 'EEE', 'BBA', 'ENG']),
            'marks'      => fake()->randomFloat(2, 0, 100),
            'email'      => fake()->unique()->safeEmail(),
        ];
    }
}
