<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Biodata>
 */
class BiodataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pekerjaan = [
            'Karyawan Swasta',
            'Wirausaha',
            'POLRI',
            'TNI',
            'PNS',
            'BUMN',
            'BUMD',
            'MAGANG',
            'Tidak Punya Pekerjaan',
        ];


        $enumValues = [
            'Lajang',
            'Duda',
            'Janda',
            'Menikah',
        ];

        return [

            'phone' => fake()->phoneNumber(),
            'phone_wa' =>  fake()->phoneNumber(),
            'status_hubungan' => fake()->randomElement($enumValues),
            'current_address' =>  fake()->address(),
            'city' => 1,
            'province' => 1,
            'district' => fake()->numberBetween(1, 20),
            'pekerjaan' => fake()->randomElement($pekerjaan)
        ];
    }
}
