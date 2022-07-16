<?php

namespace Database\Factories;

use App\Models\PhoneBook;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhoneBookFactory extends Factory
{
    protected $model = PhoneBook::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'image' => null,
            'address' => fake()->address(),
            'long' => fake()->longitude($min = -180, $max = 180),
            'lat' => fake()->latitude($min = -90, $max = 90),
            'nid' => fake()->randomNumber(9, true),
        ];
    }
}
