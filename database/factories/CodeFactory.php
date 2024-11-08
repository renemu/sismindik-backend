<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected static ?string $code;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'code' => static::$code ??= Hash::make('code'),
        ];
    }
}
