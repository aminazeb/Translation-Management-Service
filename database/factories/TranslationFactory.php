<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lang'    => $this->faker->randomElement(['en', 'fr', 'es','ar']),
            'key'     => $this->faker->unique()->slug,
            'content' => $this->faker->sentence,
            'tag'     => $this->faker->randomElement(['mobile', 'desktop', 'web']),
        ];
    }
}
