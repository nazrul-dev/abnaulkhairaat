<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AngkatanUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enumValues = ['mi', 'mts', 'ma'];
        $currentYear = date('Y');
        return [
            'angkatan' => fake()->numberBetween(2000, $currentYear), // Ini akan menghasilkan tahun acak antara 2000 dan tahun sekarang
            'tipe_angkatan' => fake()->randomElement($enumValues),
            'tahun_kelulusan' => fake()->numberBetween(2000, $currentYear), // Ini akan menghasilkan tahun acak antara 2000 dan tahun sekarang
        ];
    }
}
