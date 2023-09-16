<?php

namespace Database\Factories;

use File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravolt\Avatar\Avatar;


// create your first avatar

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $avatars = new Avatar(config('laravolt.avatar'));
        $name =  Str::slug(fake()->name());
        $pathname = public_path('storage/avatars/' . $name) . '.png';
        $avatars->create($name)->save($pathname);
        return [
            'name' => $name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Ganti 'password' dengan kata sandi default yang Anda inginkan
            'remember_token' => Str::random(10),
            'avatar' =>   'avatars/'. $name . '.png', // Isi dengan nilai yang sesuai sesuai kebutuhan
            'isadmin' => false,
            'isbiodata' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
