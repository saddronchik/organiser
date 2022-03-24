<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'document_number' => $this->faker->text(15),
            'preamble' => $this->faker->text(),
            'text' => $this->faker->realTextBetween(200,1500),
            'author_id' => random_int(1,5),
            'addressed_id' => random_int(5,10),
            'executor_id' => random_int(1,10),
            'department_id' => random_int(1,20),
            'status' => Assignment::STATUS_IN_PROGRESS,
            'deadline' => $this->faker->dateTime(),
            'real_deadline' => $this->faker->dateTimeBetween('-1 years', 'now'),
        ];
    }
}
