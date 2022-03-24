<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    public function definition()
    {
        return [
            'full_name' => $this->faker->unique()->name(),
        ];
    }

}
