<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'), // default password for testing
            'email' => $this->faker->unique()->safeEmail,
            'full_name' => $this->faker->name,
            'birth_date' => $this->faker->date(),
            'profile_image' => $this->faker->imageUrl(100, 100, 'people')
        ];
    }
}

