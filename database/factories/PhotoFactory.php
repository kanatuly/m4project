<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->image('storage/app/public/photos', 640, 480, null, false),
            'description' => $this->faker->text(20), 
        ];
    }
}
